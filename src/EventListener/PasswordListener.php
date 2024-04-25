<?php

namespace App\EventListener;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class PasswordListener implements EventSubscriberInterface
{
    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface|UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ["hashPasswordForNewEntity"],
            BeforeEntityUpdatedEvent::class => ["hashPasswordForUpdatedEntity"],
        ];
    }
    public function hashPasswordForNewEntity(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }

        $password = $entity->getPassword();

        if ($password) {
            $hashedPassword = $this->passwordHasher->hashPassword($entity, $password);
            $entity->setPassword($hashedPassword);
        }
    }
    public function hashPasswordForUpdatedEntity(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $password = $entity->getPassword();
        if ($password) {
            $hashedPassword = $this->passwordHasher->hashPassword($entity, $password);
            $entity->setPassword($hashedPassword);
        }
    }
}