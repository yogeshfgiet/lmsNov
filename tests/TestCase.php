<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://raj.lms.local';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        //add constants for testing
        require __DIR__.'/Constants.php';

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * login to application as admin
     *
     * @return \Illuminate\Foundation\Application
     */
    public function loginAsAdmin()
    {
        //To remove middlewares
        $this->withoutMiddleware();
        $this->post('/auth/login',
            ['email' => ADMIN_EMAIL,
                'password' => ADMIN_PASSWORD])
            ->assertRedirectedTo('/home');
    }
}
