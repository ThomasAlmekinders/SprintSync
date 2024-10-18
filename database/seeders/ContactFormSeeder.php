<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactFormSeeder extends Seeder
{
    public function run(): void
    {
        $contactFormData = $this->getContactFormData();
        
        foreach ($contactFormData as $formData) {
            DB::table('contact_form_submissions')->insert(array_merge($formData, [
                'status' => 'new',
                'logged_in_user_id' => null,
                'ip_address' => request()->ip(), // Hier kan je IP-adres ophalen van de request
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    function getContactFormData(): array {
        return [
            [
                'first_name' => 'Thomas',
                'last_name' => 'Almekinders',
                'email' => 'almekinders.t@gmail.com',
                'phone_number' => '0615437392',
                'subject' => 'Vraag over mijn account',
                'message' => 'Beste supportteam,\n\nIk heb een vraag over mijn accountinstellingen. Ik kan niet inloggen omdat ik mijn wachtwoord ben vergeten. Is er een manier om mijn wachtwoord opnieuw in te stellen? Ik waardeer uw hulp hierbij.\n\nMet vriendelijke groet,\nThomas Almekinders',
            ],
            [
                'first_name' => 'Jan',
                'last_name' => 'Jansen',
                'email' => 'jan.jansen@example.com',
                'phone_number' => '0612345678',
                'subject' => 'Probleem met mijn bestelling',
                'message' => 'Hallo,\n\nIk heb onlangs een bestelling geplaatst (ordernummer: 12345), maar ik heb deze nog steeds niet ontvangen. Kunt u alstublieft de status van mijn bestelling controleren? Het zou gisteren geleverd moeten worden. Dank u voor uw hulp!\n\nMet vriendelijke groet,\nJan Jansen',
            ],
            [
                'first_name' => 'Piet',
                'last_name' => 'Pietersen',
                'email' => 'piet.pietersen@example.com',
                'phone_number' => '0623456789',
                'subject' => 'Feedback over de website',
                'message' => 'Geachte heer/mevrouw,\n\nIk wilde mijn feedback delen over uw website. Ik vind de lay-out erg aantrekkelijk, maar ik had moeite met het vinden van de contactinformatie. Misschien kan deze sectie prominenter worden gemaakt? Dit zou het voor gebruikers gemakkelijker maken om hulp te krijgen wanneer dat nodig is. Bedankt voor uw aandacht!\n\nMet vriendelijke groet,\nPiet Pietersen',
            ],
            [
                'first_name' => 'Sara',
                'last_name' => 'Vermeer',
                'email' => 'sara.vermeer@example.com',
                'phone_number' => '0619876543',
                'subject' => 'Aanvraag voor informatie',
                'message' => 'Hallo,\n\nIk ben geïnteresseerd in uw diensten en zou graag meer informatie ontvangen. Kunt u me vertellen welke pakketten u aanbiedt en wat de prijzen zijn? Ik kijk uit naar uw reactie.\n\nMet vriendelijke groet,\nSara Vermeer',
            ],
            [
                'first_name' => 'Klaas',
                'last_name' => 'Hendriks',
                'email' => 'klaas.hendriks@example.com',
                'phone_number' => '0623456781',
                'subject' => 'Probleem met het aanmelden voor de nieuwsbrief',
                'message' => 'Beste team,\n\nIk probeer me al een paar dagen aan te melden voor de nieuwsbrief, maar het lijkt niet te werken. Ik krijg geen bevestigingsmail. Kunnen jullie dit voor mij nakijken? Ik ben echt geïnteresseerd in jullie updates.\n\nBedankt!\nKlaas Hendriks',
            ],
        ];
    }    
}
