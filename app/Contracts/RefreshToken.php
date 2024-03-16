<?php

namespace App\Contracts;

class RefreshToken {
  public string $access_token;
  public string $token_type;
  public int $expires_in;

  public function __construct(string $access_token, string $token_type, int $expires_in) {
    $this->access_token = $access_token;
    $this->token_type = $token_type;
    $this->expires_in = $expires_in;
  }
}