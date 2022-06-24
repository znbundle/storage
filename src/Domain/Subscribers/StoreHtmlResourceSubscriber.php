<?php

namespace ZnBundle\Storage\Domain\Subscribers;

use Illuminate\Support\Collection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnBundle\Storage\Domain\Dto\MatchDto;
use ZnBundle\Storage\Domain\Interfaces\Services\UploadServiceInterface;
use ZnCore\Base\FileSystem\Helpers\MimeTypeHelper;
use ZnCore\Domain\Domain\Enums\EventEnum;
use ZnCore\Domain\Domain\Events\EntityEvent;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\EntityManager\Traits\EntityManagerAwareTrait;

class StoreHtmlResourceSubscriber implements EventSubscriberInterface
{

    use EntityManagerAwareTrait;

    public $serviceId;
    public $attribute;

    private $uploadService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UploadServiceInterface $uploadService
    )
    {
        $this->setEntityManager($entityManager);
        $this->uploadService = $uploadService;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::AFTER_CREATE_ENTITY => 'onBeforePersistEntity',
            EventEnum::BEFORE_UPDATE_ENTITY => 'onBeforePersistEntity',
        ];
    }

    public function onBeforePersistEntity(EntityEvent $event)
    {
        /** @var EntityIdInterface $entity */
        $entity = $event->getEntity();
        $content = EntityHelper::getValue($entity, $this->attribute);
        $collection = $this->matchAll($content);
        if ($collection->count()) {
            foreach ($collection as $matchDto) {
                $fileEntity = $this->uploadService->makeFile($this->serviceId, $entity->getId(), $matchDto->getFileName(), $matchDto->getContent());
                $newSrcAttribute = 'src="' . $fileEntity->getUri() . '"';
                $content = str_replace($matchDto->getSrcAttribute(), $newSrcAttribute, $content);
                EntityHelper::setAttribute($entity, $this->attribute, $content);
                $this->getEntityManager()->persist($entity);
            }
        }
    }

    /**
     * @param string $content
     * @return Collection | MatchDto[]
     */
    private function matchAll(string $content): Collection
    {
        $collection = new Collection();
        $isMatch = preg_match_all('/src=\"data:([^;]+);base64,([^\"]*)\"(\s+data-filename=\"([^\"]*)\")?/i', $content, $matches);
        if ($isMatch) {
            foreach ($matches[0] as $index => $value) {
                $matchDto = new MatchDto();
                $mime = $matches[1][$index];
                $matchDto->setFileName($matches[4][$index] ?? $this->forgeFileName($mime));
                $matchDto->setMime($mime);
                $matchDto->setContent(base64_decode($matches[2][$index]));
                $matchDto->setSrcAttribute($matches[0][$index]);
                $collection->add($matchDto);
            }
        }
        return $collection;
    }

    private function forgeFileName($mime): string
    {
        $ext = MimeTypeHelper::getExtensionByMime($mime);
        return 'embed image.' . $ext;
    }
}