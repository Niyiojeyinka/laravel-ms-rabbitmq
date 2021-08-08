<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    public $email;
    public $password;

    public function __construct()
    {
        parent::__construct();
        $this->password = "password";
        $this->email = "test@gmail.com";
    }

    /**
     *  Register new user
     *@return void
     */
    public function register()
    {
        User::create(
            [
                'name' => $this->faker()->name(),
                'password' => Hash::make($this->password),
                'email' => $this->email,
            ]

        );
    }
    /**
     *  user sign in
     *@return \Illuminate\Testing\TestResponse
     */
    public function login($email = null, $password = null)
    {

        $this->register();
        return $this->post('api/login', [
            'password' => $password == null ? $this->password : $password,
            'email' =>  $email == null ? $this->email : $email,
        ]);
    }

    /**
     * test User can register
     * @test
     * @enlighten
     * @return void
     */
    public function testUserCanRegister()
    {
        $response = $this->post('api/register', [
            'name' => $this->faker()->name(),
            'password' => $this->password,
            'email' => $this->email,
        ]);
        $response->assertOk();
    }

    /**
     * test user can signin
     * @test
     * @enlighten
     * @return void
     */
    public function userCanLogin()
    {

        $response = $this->login();

        $response->assertOk();
    }

    /**
     * test wrong user cant signin
     * @test
     * @enlighten
     * @return void
     */
    public function userWrongCredentialCantLogin()
    {
      //$this->withoutExceptionHandling();
        $response = $this->login(null,'wrongpassword');
       // dd($response);
        $response->assertStatus(401);
    }
}
