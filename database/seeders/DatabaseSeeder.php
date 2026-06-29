<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Show;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::firstOrCreate(
            ['email' => 'admin@aurora.nl'],
            ['name' => 'Admin', 'password' => Hash::make('password123'), 'role' => 'administrator']
        );

        // Medewerker account
        User::firstOrCreate(
            ['email' => 'medewerker@aurora.nl'],
            ['name' => 'Test Medewerker', 'password' => Hash::make('password123'), 'role' => 'medewerker']
        );

        // Klant account
        $klant = User::firstOrCreate(
            ['email' => 'klant@aurora.nl'],
            ['name' => 'Jan de Vries', 'password' => Hash::make('password123'), 'role' => 'bezoeker']
        );

        // 3 Neppe shows
        $shows = [
            [
                'title' => 'Zwanenmeer Klassiek',
                'description' => 'Een adembenemende, grootschalige uitvoering van het wereldberoemde ballet, begeleid door het voltallige nationaal symfonieorkest. Mis deze eenmalige galavoorstelling niet.',
                'date' => '2026-06-12 20:00:00',
                'location' => 'Grote Zaal',
                'category' => 'Ballet & Dans',
                'image_url' => 'https://images.unsplash.com/photo-1514306191717-452ec28c7814?q=80&w=800&auto=format&fit=crop',
                'available_tickets' => 150,
                'price' => 45.00,
            ],
            [
                'title' => 'Jazz Night: The Legends',
                'description' => 'Een exclusieve avond vol soepele jazzklanken in onze intieme foyer. Inclusief welkomstdrankje.',
                'date' => '2026-06-18 19:30:00',
                'location' => 'Foyer',
                'category' => 'Muziek & Concert',
                'image_url' => 'https://images.unsplash.com/photo-1503095396549-807759245b35?q=80&w=800&auto=format&fit=crop',
                'available_tickets' => 80,
                'price' => 35.00,
            ],
            [
                'title' => 'Hamlet Modern',
                'description' => 'Een vernieuwende, rauwe en eigentijdse vertaling van Shakespeare\'s meesterwerk. Theater op het scherpst van de snede.',
                'date' => '2026-06-24 20:15:00',
                'location' => 'Grote Zaal',
                'category' => 'Theater & Toneel',
                'image_url' => 'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?q=80&w=800&auto=format&fit=crop',
                'available_tickets' => 120,
                'price' => 30.00,
            ],
        ];

        $showModels = [];
        foreach ($shows as $show) {
            $showModels[] = Show::create($show);
        }

        // Nep-reserveringen
        $reservations = [
            [
                'user_id' => $klant->id,
                'show_id' => $showModels[0]->id,
                'show_name' => 'Zwanenmeer Klassiek',
                'show_date' => '2026-06-12 20:00:00',
                'ticket_barcode' => 'AUR-2026-00001',
                'number_of_tickets' => 2,
                'status' => 'gereserveerd',
            ],
            [
                'user_id' => $klant->id,
                'show_id' => $showModels[1]->id,
                'show_name' => 'Jazz Night: The Legends',
                'show_date' => '2026-06-18 19:30:00',
                'ticket_barcode' => 'AUR-2026-00002',
                'number_of_tickets' => 3,
                'status' => 'gereserveerd',
            ],
            [
                'user_id' => $klant->id,
                'show_id' => $showModels[2]->id,
                'show_name' => 'Hamlet Modern',
                'show_date' => '2026-06-24 20:15:00',
                'ticket_barcode' => 'AUR-2026-00003',
                'number_of_tickets' => 1,
                'status' => 'gescand',
            ],
        ];

        foreach ($reservations as $r) {
            Reservation::firstOrCreate(
                ['ticket_barcode' => $r['ticket_barcode']],
                $r
            );
        }
    }
}
