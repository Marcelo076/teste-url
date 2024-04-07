<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\RedirectLog;
use App\Models\Redirect;

class StatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_access_statistics_are_correct()
    {
        
        $redirect = Redirect::factory()->create();
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => '127.0.0.1']);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => '127.0.0.1']);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => '127.0.0.2', 'referer' => 'http://example.com']);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => '127.0.0.2', 'referer' => 'http://example.com']);
        RedirectLog::factory()->create(['redirect_id' => $redirect->id, 'ip' => '127.0.0.3']);

      
        $response = $this->get(route('stats', ['redirect' => $redirect->id]));

   
        $response->assertStatus(200);

        
        $response->assertViewHas('stats', function ($stats) {
            return $stats['totalAccesses'] === 5 && 
                $stats['uniqueAccesses'] === 3 && 
                $stats['topReferrers']->count() === 1 && 
                $stats['topReferrers'][0]->referer === 'http://example.com' && 
                $stats['accessesLast10Days']->count() === 1 && 
                $stats['accessesLast10Days'][0]->total === 5 && 
                $stats['accessesLast10Days'][0]->unique_count === 3; 
        });
    }

    public function test_access_statistics_when_no_logs_exist()
    {
  
        $redirect = Redirect::factory()->create();

   
        $response = $this->get(route('stats', ['redirect' => $redirect->id]));

     
        $response->assertStatus(200);


        $response->assertViewHas('stats', function ($stats) {
            return $stats['totalAccesses'] === 0 && 
                $stats['uniqueAccesses'] === 0 && 
                $stats['topReferrers']->isEmpty() && 
                $stats['accessesLast10Days']->isEmpty(); 
        });
    }
}
