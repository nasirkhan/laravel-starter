<?php

namespace App\Support;

class Flash
{
    protected string $message;

    protected string $level = 'info';

    protected bool $important = false;

    protected bool $overlay = false;

    protected string $title = 'Notice';

    public function __construct(string $message = '')
    {
        $this->message = $message;
    }

    public function message(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function success(string $message = ''): static
    {
        $this->level = 'success';
        if ($message) {
            $this->message = $message;
        }

        return $this->commit();
    }

    public function error(string $message = ''): static
    {
        $this->level = 'danger';
        if ($message) {
            $this->message = $message;
        }

        return $this->commit();
    }

    public function warning(string $message = ''): static
    {
        $this->level = 'warning';
        if ($message) {
            $this->message = $message;
        }

        return $this->commit();
    }

    public function info(string $message = ''): static
    {
        $this->level = 'info';
        if ($message) {
            $this->message = $message;
        }

        return $this->commit();
    }

    public function important(): static
    {
        $this->important = true;

        return $this->commit();
    }

    public function overlay(string $title = 'Notice'): static
    {
        $this->overlay = true;
        $this->title = $title;

        return $this->commit();
    }

    protected function commit(): static
    {
        $messages = session('flash_notification', collect());

        if (! $messages instanceof \Illuminate\Support\Collection) {
            $messages = collect($messages);
        }

        $existing = $messages->search(fn ($m) => $m['message'] === $this->message);

        $entry = [
            'message' => $this->message,
            'level' => $this->level,
            'important' => $this->important,
            'overlay' => $this->overlay,
            'title' => $this->title,
        ];

        if ($existing !== false) {
            $messages->put($existing, $entry);
        } else {
            $messages->push($entry);
        }

        session()->flash('flash_notification', $messages);

        return $this;
    }

    public static function __callStatic(string $method, array $args): static
    {
        return (new static($args[0] ?? ''))->$method($args[0] ?? '');
    }
}
