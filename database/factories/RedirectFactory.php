<?php

namespace Database\Factories;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RedirectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Redirect::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => $this->faker->url,
            'date_create' => now()->timestamp,
            'last_update' => now()->timestamp,
            'active' => true,
        ];
    }

    /**
     * Define a state with a valid URL.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withValidUrl()
    {
        return $this->state(function (array $attributes) {
            return [
                'url' => 'https://www.example.com',
            ];
        });
    }

    /**
     * Define a state with an invalid URL due to invalid DNS.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withInvalidDnsUrl()
    {
        return $this->state(function (array $attributes) {
            return [
                'url' => 'https://invalid-domain.test',
            ];
        });
    }

    /**
     * Define a state with an invalid URL.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withInvalidUrl()
    {
        return $this->state(function (array $attributes) {
            return [
                'url' => 'invalid-url',
            ];
        });
    }

    /**
     * Define a state with URL pointing to the own application.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withInternalUrl()
    {
        return $this->state(function (array $attributes) {
            return [
                'url' => config('app.url'),
            ];
        });
    }

    /**
     * Define a state with URL without HTTPS.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withoutHttpsUrl()
    {
        return $this->state(function (array $attributes) {
            return [
                'url' => 'http://www.example.com',
            ];
        });
    }

    /**
     * Define a state with URL returning a status different from 200 or 201.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withDifferentStatusUrl()
    {
        return $this->state(function (array $attributes) {
            return [
                'url' => 'https://httpstat.us/404',
            ];
        });
    }

    /**
     * Define a state with URL having query params with empty keys.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withEmptyQueryParamUrl()
    {
        return $this->state(function (array $attributes) {
            return [
                'url' => 'https://www.example.com?utm_source=&utm_campaign=test',
            ];
        });
    }

    // Outros métodos de estado para atender aos requisitos restantes de teste podem ser adicionados aqui.

}
