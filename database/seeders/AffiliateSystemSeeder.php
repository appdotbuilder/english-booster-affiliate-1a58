<?php

namespace Database\Seeders;

use App\Models\AffiliateLink;
use App\Models\Program;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AffiliateSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@englishbooster.com'],
            [
                'name' => 'English Booster Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create some affiliate users
        $affiliates = [];
        for ($i = 1; $i <= 5; $i++) {
            $affiliates[] = User::firstOrCreate(
                ['email' => "affiliate{$i}@example.com"],
                [
                    'name' => "Affiliate User {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'affiliate',
                    'is_active' => true,
                ]
            );
        }

        // Create programs
        $programs = [
            // Online Programs
            [
                'name' => 'Kids English',
                'description' => 'Fun English learning program for children ages 6-12',
                'category' => 'online',
                'price' => 1500000,
                'commission_percentage' => 15,
            ],
            [
                'name' => 'Teen English',
                'description' => 'Interactive English program for teenagers',
                'category' => 'online',
                'price' => 2000000,
                'commission_percentage' => 18,
            ],
            [
                'name' => 'TOEFL Easy Peasy',
                'description' => 'Comprehensive TOEFL preparation course',
                'category' => 'online',
                'price' => 2500000,
                'commission_percentage' => 20,
            ],
            [
                'name' => 'Private General English',
                'description' => 'One-on-one English tutoring sessions',
                'category' => 'online',
                'price' => 3000000,
                'commission_percentage' => 25,
            ],
            [
                'name' => 'Speaking Booster',
                'description' => 'Intensive speaking practice program',
                'category' => 'online',
                'price' => 1800000,
                'commission_percentage' => 17,
            ],
            [
                'name' => 'Grammar Booster',
                'description' => 'Complete English grammar mastery course',
                'category' => 'online',
                'price' => 1600000,
                'commission_percentage' => 16,
            ],

            // Offline Programs (Pare)
            [
                'name' => 'Paket 2 minggu',
                'description' => '2-week intensive English course in Pare',
                'category' => 'offline_pare',
                'location' => 'Pare',
                'price' => 2000000,
                'commission_percentage' => 15,
            ],
            [
                'name' => 'Paket 1 bulan',
                'description' => '1-month comprehensive English program in Pare',
                'category' => 'offline_pare',
                'location' => 'Pare',
                'price' => 3500000,
                'commission_percentage' => 18,
            ],
            [
                'name' => 'Paket 2 bulan',
                'description' => '2-month intensive English immersion in Pare',
                'category' => 'offline_pare',
                'location' => 'Pare',
                'price' => 6000000,
                'commission_percentage' => 20,
            ],
            [
                'name' => 'Paket 3 bulan',
                'description' => '3-month complete English mastery program in Pare',
                'category' => 'offline_pare',
                'location' => 'Pare',
                'price' => 8000000,
                'commission_percentage' => 22,
            ],
            [
                'name' => 'TOEFL RPL',
                'description' => 'TOEFL preparation for university recognition (RPL)',
                'category' => 'offline_pare',
                'location' => 'Pare',
                'price' => 4500000,
                'commission_percentage' => 25,
            ],

            // Group Programs
            [
                'name' => 'English Trip',
                'description' => 'Educational English tour and learning experience',
                'category' => 'group',
                'price' => 5000000,
                'commission_percentage' => 20,
            ],
            [
                'name' => 'Special English Day',
                'description' => 'One-day intensive English workshop',
                'category' => 'group',
                'price' => 500000,
                'commission_percentage' => 15,
            ],

            // Branch Programs
            [
                'name' => 'Cilukba (Pre-school / TK)',
                'description' => 'English program for pre-school children',
                'category' => 'branch',
                'location' => 'Malang',
                'price' => 1200000,
                'commission_percentage' => 12,
            ],
            [
                'name' => 'Hompimpa (SD)',
                'description' => 'English program for elementary school students',
                'category' => 'branch',
                'location' => 'Sidoarjo',
                'price' => 1400000,
                'commission_percentage' => 14,
            ],
            [
                'name' => 'Hip Hip Hurray (SMP)',
                'description' => 'English program for middle school students',
                'category' => 'branch',
                'location' => 'Nganjuk',
                'price' => 1600000,
                'commission_percentage' => 16,
            ],
        ];

        foreach ($programs as $programData) {
            Program::firstOrCreate(
                ['name' => $programData['name']],
                $programData
            );
        }

        // Create affiliate links for some programs
        $createdPrograms = Program::all();
        foreach ($affiliates as $affiliate) {
            // Create 2-4 affiliate links per affiliate
            $programsToLink = $createdPrograms->random(random_int(2, 4));
            foreach ($programsToLink as $program) {
                if (!AffiliateLink::where('user_id', $affiliate->id)->where('program_id', $program->id)->exists()) {
                    AffiliateLink::create([
                        'user_id' => $affiliate->id,
                        'program_id' => $program->id,
                        'clicks' => random_int(0, 100),
                    ]);
                }
            }
        }

        // Create some sample sales
        $affiliateLinks = AffiliateLink::all();
        foreach ($affiliateLinks as $link) {
            // 30% chance of having sales for each link
            if (random_int(1, 100) <= 30) {
                $salesCount = random_int(1, 3);
                for ($i = 0; $i < $salesCount; $i++) {
                    $saleAmount = $link->program->price;
                    $commissionRate = $link->program->commission_percentage;
                    $commissionAmount = ($saleAmount * $commissionRate) / 100;

                    Sale::create([
                        'affiliate_id' => $link->user_id,
                        'program_id' => $link->program_id,
                        'tracking_code' => $link->tracking_code,
                        'customer_name' => 'Sample Customer ' . random_int(100, 999),
                        'customer_email' => 'customer' . random_int(100, 999) . '@example.com',
                        'customer_phone' => '08' . random_int(1000000000, 9999999999),
                        'sale_amount' => $saleAmount,
                        'commission_rate' => $commissionRate,
                        'commission_amount' => $commissionAmount,
                        'status' => ['pending', 'confirmed', 'confirmed', 'confirmed'][random_int(0, 3)], // 75% confirmed
                        'sale_date' => now()->subDays(random_int(1, 90)),
                    ]);
                }
            }
        }
    }
}