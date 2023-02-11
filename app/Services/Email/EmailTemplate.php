<?php

namespace App\Services\Email;

class EmailTemplate
{
    private function __construct(
        private string $email,
        private array $data
    ) {
    }

    public static function from(string $email, array $data): static
    {
        return new static($email, $data);
    }

    public function parse(): string
    {
        $html = $this->email;

        foreach ($this->data as $key => $value) {
            if ($value) {
                $html = str_replace("{{$key}}", $value, $html);
            }
        }

        return $html;
    }
}
