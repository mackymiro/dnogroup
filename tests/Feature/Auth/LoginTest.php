<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class LoginTest extends TestCase
{


    
    public function test_user_cannot_login_with_incorrect_password(){
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'hello-world'),

        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);


        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    public function test_user_can_login_with_correct_credentials(){
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'hello-world'),

        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);

    }

    public function test_user_cannot_view_a_login_form_when_authenticated(){
        
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
   
    public function test_user_can_view_a_login_form(){
        $response  = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }


}
