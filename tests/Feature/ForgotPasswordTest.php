<?php

namespace Tests\Feature\Auth;

use App\User; 

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_receives_an_email_with_a_password_reset_link()
    {
       
        Notification::fake();
        $user = factory(User::class)->create();
      
        $response = $this->post('/password/email', [
            'email' => $user->email,
        ]);

         
    }
        
}
