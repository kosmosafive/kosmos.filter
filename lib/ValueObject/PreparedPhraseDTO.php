<?php

namespace Kosmos\Filter\ValueObject;

class PreparedPhraseDTO
{
    protected array $wordList = [];
    protected array $ignoredWordList = [];
    protected array $preparedList = [];

    public function __construct(
        protected readonly string $origin
    ) {
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getWordList(): array
    {
        return $this->wordList;
    }

    public function getIgnoredWordList(): array
    {
        return $this->ignoredWordList;
    }

    public function getPreparedList(): array
    {
        return empty($this->preparedList) ? [$this->origin] : $this->preparedList;
    }

    public function setWordList(array $wordList): PreparedPhraseDTO
    {
        $this->wordList = $wordList;
        return $this;
    }

    public function setIgnoredWordList(array $ignoredWordList): PreparedPhraseDTO
    {
        $this->ignoredWordList = $ignoredWordList;
        return $this;
    }

    public function setPreparedList(array $preparedList): PreparedPhraseDTO
    {
        $this->preparedList = $preparedList;
        return $this;
    }

    public function isInteger(): bool
    {
        return is_numeric($this->origin) && ((int)$this->origin == $this->origin);
    }
}