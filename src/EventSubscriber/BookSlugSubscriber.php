<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Book;

class BookSlugSubscriber implements EventSubscriber
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function getSubscribedEvents(): array
    {
        return ['prePersist', 'preUpdate'];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->setSlug($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->setSlug($args);
    }

    private function setSlug(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Book) {
            return;
        }

        if (!$entity->getSlug() && $entity->getTitle()) {
            $slug = strtolower($this->slugger->slug($entity->getTitle()));
            $entity->setSlug($slug);
        }
    }
}