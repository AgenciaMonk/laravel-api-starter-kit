<?php

namespace Tests\Feature;

use App\User;
use Tests\ApiTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Factory;

class AuthControllerTest extends ApiTestCase
{
    use DatabaseMigrations, DatabaseTransactions, Factory;
    private $urlTokenIssue = '/api/auth/token';
    private $urlTokenRevoke = '/api/auth/token/revoke';
    private $urlTokenRefresh = '/api/auth/token/refresh';


  /**
   * Check for Invalid Credentials
   */

  public function testCheckInvalidCredentials()
  {
      $response = $this->json('POST', $this->urlTokenIssue, [
         'email' => 'developer@vuejsisawesome.com',
         'password' => '12312313123',
     ]);
      $response->assertStatus(401)
               ->assertJson(['messages' => [trans('auth.failed')],]);
  }

  /**
   * Check User Can Get A Login
   */

  public function testCanAnGetAutenticatedToken()
  {
      $email = 'hello@example.com';
      $password = 'dummypassword';

      $this->create(User::class, [
          'email' => $email,
          'password' => bcrypt($password),
      ]);

      $response = $this->json('POST', $this->urlTokenIssue, [
        'email' => $email,
        'password' => $password,
     ]);

      $response->assertStatus(200)
               ->assertJsonStructure([
                'token',
                'token_ttl',
                'user' => [
                    'data' => [
                            'id',
                            'name',
                            'email',
                      ],
                ],
        ]);
  }

  /**
   * Check Login Throttle
   */

  public function testIsCheckingForLoginThrottle()
  {
      for ($i = 0; $i < 6; $i++) {
          $response = $this->makeRequestWithInvalidCredentials();
      }
      $response->assertStatus(429)
                  ->assertJsonStructure(['messages']);
  }

  /**
   * Check Login Throttle
   */

  public function testIsCheckingForRevokedToken()
  {
      $headers = $this->makeHeaders();

      $response = $this->json('POST', $this->urlTokenRevoke, [], $headers);
      $response->assertStatus(204);

      $response =  $this->json('POST', $this->urlTokenRevoke, [], $headers);
      $response->assertStatus(401);
  }

    public function testCheckUnauthorizedAccess()
    {
        $headers = [
             'Accept' => 'application/json',
             'Content-Type' => 'application/json',
             'Authorization' => 'Bearer invalid'
         ];
        $response = $this->json('POST', $this->urlTokenRevoke, [], $headers);
        $response->assertStatus(401)
                  ->assertJsonStructure([
                 'messages',
             ]);
    }

    public function testCheckAccessWithoutToken()
    {
        $headers = [
             'Accept' => 'application/json',
             'Content-Type' => 'application/json',
         ];

        $response = $this->json('POST', $this->urlTokenRevoke, [], $headers);

        $response->assertStatus(401)
                  ->assertJsonStructure([
                 'messages' => [],
             ]);
    }

    public function testIsCheckingForRefreshedToken()
    {
        $headers = $this->makeHeaders();
        $response = $this->json('POST', $this->urlTokenRefresh, [], $headers);
        $response->assertStatus(200)
                    ->assertJsonStructure(['token', 'token_ttl']);
    }

    private function makeRequestWithInvalidCredentials()
    {
        return $this->json('POST', $this->urlTokenIssue, [
              'email' => 'hello@example.com',
              'password' => 'dummypassword',
          ]);
    }

    private function makeHeaders()
    {
        $user = $this->createUser();
        $token = JWTAuth::fromUser($user);
        return [
             'Accept' => 'application/json',
             'Content-Type' => 'application/json',
             'Authorization' => 'Bearer ' . $token
         ];
    }

    private function createUser()
    {
        return $this->create(User::class, [
           'email' => 'hello@example.com',
           'password' => bcrypt(123456),
       ]);
    }
}
