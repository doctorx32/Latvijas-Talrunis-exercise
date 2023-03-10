<?php
declare(strict_types=1);

namespace App\Manager;

use App\Exception\StackEmptyException;
use App\Model\PushModel;
use App\Registry\NumberStackRegistry;
use NumberFormatter;

final class NumberStackManager implements NumberStackManagerInterface
{
    private NumberStackRegistry $numberStackRegistry;
    private FormatterManagerInterface $formatterManager;

    public function __construct(NumberStackRegistry $numberStackRegistry, FormatterManager $formatterManager)
    {
        $this->numberStackRegistry = $numberStackRegistry;
        $this->formatterManager = $formatterManager;
    }

    public function onPush(PushModel $pushModel): void
    {
        $this->numberStackRegistry->addNumber($pushModel->getNumber());
    }

    public function onPop(): string
    {
        try {
            $number = $this->numberStackRegistry->pop();
        } catch (StackEmptyException $e) {
            return 'Empty queue';
        }

        return $this->formatterManager->format($number);
    }
}
