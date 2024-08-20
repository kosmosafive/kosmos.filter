<?php

namespace Kosmos\Filter\Handler;

use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Localization\Loc;
use Kosmos\Filter\Field;
use Kosmos\Filter\Handler;

final class Factory
{
    private HandlerCollection $handlerCollection;
    private static self $instance;

    public const string MODULE_ID = 'kosmos.filter';
    public const string EVENT_ON_CREATE = 'onCreateHandlerCollection';

    private function __construct()
    {
        $this->handlerCollection = new HandlerCollection();

        $events = (new Event(
            self::MODULE_ID,
            self::EVENT_ON_CREATE,
        ));
        $events->send();

        foreach ($events->getResults() as $eventResult) {
            if ($eventResult->getType() !== EventResult::SUCCESS) {
                continue;
            }

            $parameters = $eventResult->getParameters();
            if (!is_array($parameters['handlerConfig'])) {
                $parameters['handlerConfig'] = [$parameters['handlerConfig']];
            }

            foreach ($parameters['handlerConfig'] as $handlerConfig) {
                if (!$handlerConfig instanceof HandlerConfig) {
                    continue;
                }

                $this->handlerCollection->add($handlerConfig);
            }
        }

        $this->handlerCollection
            ->add(new HandlerConfig(new Handler\ORM\Contains(), Field\Text::class))
            ->add(new HandlerConfig(new Handler\ORM\Range(), Field\IntegerRange::class))
            ->add(new HandlerConfig(new Handler\ORM\Range(), Field\DateRange::class))
            ->add(new HandlerConfig(new Handler\ORM\IdOrSearch(), Field\IdOrSearch::class))
            ->add(new HandlerConfig(new Handler\ORM\Equal(), Field\Select::class))
            ->add(new HandlerConfig(new Handler\ORM\Equal(), Field\Boolean::class))
            ->add(new HandlerConfig(new Handler\ORM\Equal(), Field\Integer::class))
            ->add(new HandlerConfig(new Handler\ORM\Equal(), Field\PositiveInteger::class))
            ->add(new HandlerConfig(new Handler\ORM\DatePeriod(), Field\DatePeriod::class));
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function create(
        string $queryBuilderType,
        Field\FieldInterface $field
    ): HandlerInterface {
        $instance = self::getInstance();

        return $instance->handlerCollection->get($queryBuilderType, (string)$field)
            ?? throw new \RuntimeException(
                Loc::getMessage(
                    'FILTER_HANDLER_NOT_FOUND',
                    [
                        '#TYPE#' => $queryBuilderType,
                        '#FIELD#' => (string)$field
                    ]
                )
            );
    }
}