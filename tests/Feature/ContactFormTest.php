<?php

namespace Tests\Feature;

use App\Jobs\SendNewContactAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_contact_form_stores_message_and_dispatches_alert_job(): void
    {
        config(['services.contact_alerts.channels' => ['whatsapp']]);
        Queue::fake();

        $response = $this->postJson(route('contact.store'), [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'content' => 'Hola, quiero hablar sobre un proyecto web para mi negocio.',
            'inquiry_type' => 'web',
            'web_products' => ['basic_web', 'crm'],
        ]);

        $response->assertOk()->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('messages', [
            'sender_name' => 'Ada Lovelace',
            'sender_email' => 'ada@example.com',
        ]);

        Queue::assertPushed(SendNewContactAlert::class);
    }

    public function test_public_contact_form_stores_message_without_dispatching_when_alerts_are_disabled(): void
    {
        config(['services.contact_alerts.channels' => []]);
        Queue::fake();

        $response = $this->postJson(route('contact.store'), [
            'name' => 'Grace Hopper',
            'email' => 'grace@example.com',
            'content' => 'Me interesa una propuesta para actualizar mi sitio web.',
            'inquiry_type' => 'business',
        ]);

        $response->assertOk()->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('messages', [
            'sender_name' => 'Grace Hopper',
            'sender_email' => 'grace@example.com',
        ]);

        Queue::assertNothingPushed();
    }
}
