<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /* Mijn eigen admin account toevoegen (als deze nog niet bestaat). */
        if (!DB::table('users')->where('email', 'almekinders.t@gmail.com')->first()) {
            $userId = DB::table('users')->insertGetId([
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'username' => 'T.A.',
                'first_name' => 'Thomas',
                'last_name' => 'Almekinders',
                'phone_number' => '0615437392',
                'profile_bio' => 'This is a sample user bio.',
                'profile_picture' => '/default_profile.svg',
                'is_administrator' => 1,
            ]);
            DB::table('addresses')->insert([
                'user_id' => $userId,
                'street' => 'Oosterhoutstraat',
                'house_number' => '48',
                'postcode' => '9403 NG',
                'city' => 'Assen',
                'country' => 'Nederland',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        /* Een loop om random accounts aan te maken. Met controle voor uniek username/email/telefoonnummer. */
        $users = $this->getUsers();
        $addresses = $this->getAddresses();

        foreach ($users as $index => $user) {
            $username = $this->generateUniqueUsername($user['first_name'], $user['last_name']);
            $email = $this->generateUniqueEmail($user['first_name'], $user['last_name']);
            $password = Hash::make('defaultpassword'); 
            $phoneNumber = $this->generateUniquePhoneNumber();
            $profileBio = "{$user['first_name']} {$user['last_name']} is a valued user of our platform.";

            $userId = DB::table('users')->insertGetId(array_merge($user, [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'phone_number' => $phoneNumber,
                'profile_bio' => $profileBio,
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
                'profile_picture' => '/default_profile.svg',
                'is_administrator' => 0,
            ]));

            if (isset($addresses[$index])) {
                $adres = $addresses[$index];
                DB::table('addresses')->insert(array_merge($adres, [
                    'user_id' => $userId,
                    'country' => 'Nederland',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }


    private function getUsers(): array
    {
        return [
            ['first_name' => 'Jordy', 'last_name' => 'Bartelds'],
            ['first_name' => 'Wouter', 'last_name' => 'Winkel'],
            ['first_name' => 'Matthijs', 'last_name' => 'Almekinders'],
            ['first_name' => 'Chris', 'last_name' => 'Almekinders'],
            ['first_name' => 'Margriet', 'last_name' => 'Almekinders'],
            ['first_name' => 'Aaron', 'last_name' => 'Almekinders'],
            ['first_name' => 'Babbette', 'last_name' => 'Almekinders'],
            ['first_name' => 'Robine', 'last_name' => 'Almekinders'],
            ['first_name' => 'Danique', 'last_name' => 'Almekinders'],
            ['first_name' => 'Thomas', 'last_name' => 'Steging'],
            ['first_name' => 'Sophie', 'last_name' => 'Bakker'],
            ['first_name' => 'Lucas', 'last_name' => 'Jansen'],
            ['first_name' => 'Emma', 'last_name' => 'Visser'],
            ['first_name' => 'Liam', 'last_name' => 'Huisman'],
            ['first_name' => 'Olivia', 'last_name' => 'De Vries'],
            ['first_name' => 'Noah', 'last_name' => 'Kramer'],
            ['first_name' => 'Mila', 'last_name' => 'De Boer'],
            ['first_name' => 'James', 'last_name' => 'Van Dijk'],
            ['first_name' => 'Ava', 'last_name' => 'Bos'],
            ['first_name' => 'Mason', 'last_name' => 'Mulder'],
            ['first_name' => 'Isla', 'last_name' => 'Willems'],
            ['first_name' => 'Ethan', 'last_name' => 'Postma'],
            ['first_name' => 'Luna', 'last_name' => 'Schmidt'],
            ['first_name' => 'Sebastian', 'last_name' => 'De Groot'],
            ['first_name' => 'Ella', 'last_name' => 'Veldman'],
            ['first_name' => 'Owen', 'last_name' => 'Kleijer'],
            ['first_name' => 'Zoe', 'last_name' => 'Meyer'],
            ['first_name' => 'Finn', 'last_name' => 'Smit'],
            ['first_name' => 'Chloe', 'last_name' => 'Van Leeuwen'],
            ['first_name' => 'Jack', 'last_name' => 'Vermeulen'],
            ['first_name' => 'Amelia', 'last_name' => 'Hoogland'],
            ['first_name' => 'Maya', 'last_name' => 'Peters'],
            ['first_name' => 'Daan', 'last_name' => 'Hendriks'],
            ['first_name' => 'Jasmine', 'last_name' => 'Van der Meer'],
            ['first_name' => 'Jesse', 'last_name' => 'Kool'],
            ['first_name' => 'Nora', 'last_name' => 'Kruithof'],
            ['first_name' => 'Lars', 'last_name' => 'Wolters'],
            ['first_name' => 'Lara', 'last_name' => 'Jongkind'],
            ['first_name' => 'Victor', 'last_name' => 'Zwart'],
            ['first_name' => 'Sanne', 'last_name' => 'Koster'],
            ['first_name' => 'Ruben', 'last_name' => 'Dijkstra'],
            ['first_name' => 'Amber', 'last_name' => 'Molenaar'],
            ['first_name' => 'Milan', 'last_name' => 'Van der Wal'],
            ['first_name' => 'Tessa', 'last_name' => 'Hoekstra'],
            ['first_name' => 'Sem', 'last_name' => 'De Lange'],
            ['first_name' => 'Kaylee', 'last_name' => 'Dams'],
            ['first_name' => 'Bram', 'last_name' => 'Kemp'],
            ['first_name' => 'Megan', 'last_name' => 'Kruis'],
            ['first_name' => 'Thijs', 'last_name' => 'Wiegman'],
            ['first_name' => 'Fleur', 'last_name' => 'Versteeg'],
            ['first_name' => 'Hugo', 'last_name' => 'Schouten'],
            ['first_name' => 'Nina', 'last_name' => 'Groot'],
            ['first_name' => 'Evelyn', 'last_name' => 'Bosch'],
            ['first_name' => 'Milan', 'last_name' => 'Teunissen'],
            ['first_name' => 'Anouk', 'last_name' => 'Rijks'],
            ['first_name' => 'Jordy', 'last_name' => 'Witkamp'],
            ['first_name' => 'Eva', 'last_name' => 'Verheul'],
            ['first_name' => 'Demi', 'last_name' => 'Meijer'],
            ['first_name' => 'Kylian', 'last_name' => 'Hoek'],
            ['first_name' => 'Lynn', 'last_name' => 'Scholten'],
            ['first_name' => 'Sven', 'last_name' => 'Van Dijk'],
            ['first_name' => 'Timo', 'last_name' => 'Kruidenier'],
            ['first_name' => 'Esmee', 'last_name' => 'Albrecht'],
            ['first_name' => 'Yara', 'last_name' => 'Van der Linden'],
            ['first_name' => 'Joris', 'last_name' => 'Haan'],
            ['first_name' => 'Bente', 'last_name' => 'Veldman'],
            ['first_name' => 'Ravi', 'last_name' => 'De Vries'],
            ['first_name' => 'Nikki', 'last_name' => 'Willems'],
            ['first_name' => 'Hessel', 'last_name' => 'Willemsen'],
            ['first_name' => 'Sterre', 'last_name' => 'Hofman'],
            ['first_name' => 'Mara', 'last_name' => 'Van de Beek'],
            ['first_name' => 'Jade', 'last_name' => 'Van den Berg'],
            ['first_name' => 'Kees', 'last_name' => 'Bakker'],
            ['first_name' => 'Demi', 'last_name' => 'Wolters'],
            ['first_name' => 'Ruben', 'last_name' => 'Schipper'],
            ['first_name' => 'Bo', 'last_name' => 'Dijkstra'],
            ['first_name' => 'Yara', 'last_name' => 'Van Dijk'],
            ['first_name' => 'Stefan', 'last_name' => 'Van den Berg'],
            ['first_name' => 'Tessa', 'last_name' => 'Schipper'],
            ['first_name' => 'Milan', 'last_name' => 'Van der Meer'],
            ['first_name' => 'Fleur', 'last_name' => 'Hofman'],
            ['first_name' => 'Sam', 'last_name' => 'Van Leeuwen'],
            ['first_name' => 'Max', 'last_name' => 'Jansen'],
            ['first_name' => 'Lana', 'last_name' => 'Visser'],
            ['first_name' => 'Noud', 'last_name' => 'Witkamp'],
            ['first_name' => 'Daan', 'last_name' => 'Jongkind'],
            ['first_name' => 'Alicia', 'last_name' => 'Meyer'],
            ['first_name' => 'Olivier', 'last_name' => 'Kramer'],
            ['first_name' => 'Sophie', 'last_name' => 'Hoogland'],
            ['first_name' => 'Vince', 'last_name' => 'Veldman'],
            ['first_name' => 'Hannah', 'last_name' => 'Willemsen'],
            ['first_name' => 'Kiki', 'last_name' => 'Teunissen'],
            ['first_name' => 'Luca', 'last_name' => 'Dams'],
            ['first_name' => 'Julia', 'last_name' => 'De Groot'],
            ['first_name' => 'Mats', 'last_name' => 'Van der Wal'],
            ['first_name' => 'Sarah', 'last_name' => 'Koster'],
            ['first_name' => 'Bram', 'last_name' => 'Van der Linden'],
            ['first_name' => 'Lies', 'last_name' => 'Albrecht'],
            ['first_name' => 'Joep', 'last_name' => 'Meijer'],
            ['first_name' => 'Nora', 'last_name' => 'Kruithof'],
            ['first_name' => 'Maya', 'last_name' => 'Rijks'],
            ['first_name' => 'Victor', 'last_name' => 'Wiegman'],
            ['first_name' => 'Stijn', 'last_name' => 'Versteeg'],
            ['first_name' => 'Nikki', 'last_name' => 'Hoekstra'],
            ['first_name' => 'Kyan', 'last_name' => 'Hendriks'],
            ['first_name' => 'Iris', 'last_name' => 'De Boer'],
            ['first_name' => 'Roan', 'last_name' => 'Jansen'],
            ['first_name' => 'Timo', 'last_name' => 'Kool'],
            ['first_name' => 'Zoë', 'last_name' => 'Van Leeuwen'],
            ['first_name' => 'Ravi', 'last_name' => 'Kruis'],
            ['first_name' => 'Daisy', 'last_name' => 'Hoek'],
            ['first_name' => 'Quinn', 'last_name' => 'Postma'],
            ['first_name' => 'Senn', 'last_name' => 'Van der Linden'],
            ['first_name' => 'Lars', 'last_name' => 'Molenaar'],
            ['first_name' => 'Fleur', 'last_name' => 'De Lange'],
            ['first_name' => 'Finn', 'last_name' => 'Klein'],
            ['first_name' => 'Mees', 'last_name' => 'Voss'],
        ];
        
    }

    private function generateUniqueUsername(string $firstName, string $lastName): string {
        $usernameBase = strtolower("{$firstName[0]}{$lastName}");
        $username = $usernameBase;
        $counter = 1;

        while (DB::table('users')->where('username', $username)->exists()) {
            $username = strtolower("{$firstName[0]}{$lastName}{$counter}");
            $counter++;
        }

        return $username;
    }
    private function generateUniqueEmail(string $firstName, string $lastName): string {
        $emailBase = strtolower("{$firstName}{$lastName}@gmail.com");
        $email = $emailBase;
        $counter = 1;

        while (DB::table('users')->where('email', $email)->exists()) {

            $email = strtolower("{$firstName}{$lastName}{$counter}@gmail.com");
            $counter++;
        }

        return $email;
    }
    private function generateUniquePhoneNumber(): string {
        do {
            $phoneNumber = '06' . mt_rand(10000000, 99999999);
        } while (DB::table('users')->where('phone_number', $phoneNumber)->exists());

        return $phoneNumber;
    }


    function getAddresses() {
        return [
            ['street' => 'Deelheugte', 'house_number' => '48', 'postcode' => '9403 NS', 'city' => 'Assen'],
            ['street' => 'Lariksstraat', 'house_number' => '57', 'postcode' => '9403 KW', 'city' => 'Assen'],
            ['street' => 'Oosterhoutstraat', 'house_number' => '48', 'postcode' => '9401 NG', 'city' => 'Assen'],
            ['street' => 'Oosterhoutstraat', 'house_number' => '48', 'postcode' => '9401 NG', 'city' => 'Assen'],
            ['street' => 'Oosterhoutstraat', 'house_number' => '48', 'postcode' => '9401 NG', 'city' => 'Assen'],
            ['street' => 'Oosterhoutstraat', 'house_number' => '48', 'postcode' => '9401 NG', 'city' => 'Assen'],
            ['street' => 'Oosterhoutstraat', 'house_number' => '48', 'postcode' => '9401 NG', 'city' => 'Assen'],
            ['street' => 'Oosterhoutstraat', 'house_number' => '48', 'postcode' => '9401 NG', 'city' => 'Assen'],
            ['street' => 'Oosterhoutstraat', 'house_number' => '48', 'postcode' => '9401 NG', 'city' => 'Assen'],
            ['street' => 'Marsdijkstraat', 'house_number' => '132', 'postcode' => '9405 FF', 'city' => 'Assen'],
            ['street' => 'Hoofdstraat', 'house_number' => '1', 'postcode' => '1011 AB', 'city' => 'Amsterdam'],
            ['street' => 'Lindenlaan', 'house_number' => '10', 'postcode' => '1012 CD', 'city' => 'Amsterdam'],
            ['street' => 'Dorpsstraat', 'house_number' => '20', 'postcode' => '1013 EF', 'city' => 'Amsterdam'],
            ['street' => 'Singel', 'house_number' => '5', 'postcode' => '1014 GH', 'city' => 'Amsterdam'],
            ['street' => 'Kerkstraat', 'house_number' => '15', 'postcode' => '1015 IJ', 'city' => 'Amsterdam'],
            ['street' => 'Westerstraat', 'house_number' => '25', 'postcode' => '1016 KL', 'city' => 'Amsterdam'],
            ['street' => 'Prinsengracht', 'house_number' => '30', 'postcode' => '1017 MN', 'city' => 'Amsterdam'],
            ['street' => 'Zeedijk', 'house_number' => '8', 'postcode' => '1018 OP', 'city' => 'Amsterdam'],
            ['street' => 'Damstraat', 'house_number' => '50', 'postcode' => '1019 QR', 'city' => 'Amsterdam'],
            ['street' => 'Spaarndammerstraat', 'house_number' => '12', 'postcode' => '1020 ST', 'city' => 'Amsterdam'],
            ['street' => 'Deltakade', 'house_number' => '3', 'postcode' => '1021 UV', 'city' => 'Amsterdam'],
            ['street' => 'Oosterdokskade', 'house_number' => '60', 'postcode' => '1022 WX', 'city' => 'Amsterdam'],
            ['street' => 'Zandpad', 'house_number' => '7', 'postcode' => '1023 YZ', 'city' => 'Amsterdam'],
            ['street' => 'Rozenstraat', 'house_number' => '4', 'postcode' => '1031 AB', 'city' => 'Amsterdam'],
            ['street' => 'Zonnebloemstraat', 'house_number' => '9', 'postcode' => '1032 CD', 'city' => 'Amsterdam'],
            ['street' => 'Blauwvingerstraat', 'house_number' => '11', 'postcode' => '1033 EF', 'city' => 'Amsterdam'],
            ['street' => 'Goudsbloemstraat', 'house_number' => '14', 'postcode' => '1034 GH', 'city' => 'Amsterdam'],
            ['street' => 'Molenstraat', 'house_number' => '18', 'postcode' => '1035 IJ', 'city' => 'Amsterdam'],
            ['street' => 'Zilversteeg', 'house_number' => '24', 'postcode' => '1036 KL', 'city' => 'Amsterdam'],
            ['street' => 'Silwersteeg', 'house_number' => '2', 'postcode' => '1037 MN', 'city' => 'Amsterdam'],
            ['street' => 'Sloepstraat', 'house_number' => '22', 'postcode' => '1038 OP', 'city' => 'Amsterdam'],
            ['street' => 'Zilverweg', 'house_number' => '16', 'postcode' => '1039 QR', 'city' => 'Amsterdam'],
            ['street' => 'Duitslandstraat', 'house_number' => '34', 'postcode' => '1040 ST', 'city' => 'Amsterdam'],
            ['street' => 'Marnixstraat', 'house_number' => '23', 'postcode' => '1041 UV', 'city' => 'Amsterdam'],
            ['street' => 'Tussendijken', 'house_number' => '6', 'postcode' => '1042 WX', 'city' => 'Amsterdam'],
            ['street' => 'Nederlandsestraat', 'house_number' => '45', 'postcode' => '1043 YZ', 'city' => 'Amsterdam'],
            ['street' => 'Hollandsche Kade', 'house_number' => '31', 'postcode' => '1044 AB', 'city' => 'Amsterdam'],
            ['street' => 'De Ruyterstraat', 'house_number' => '3', 'postcode' => '1045 CD', 'city' => 'Amsterdam'],
            ['street' => 'Aalsmeerweg', 'house_number' => '70', 'postcode' => '1046 EF', 'city' => 'Amsterdam'],
            ['street' => 'Westelijke Tuinstraat', 'house_number' => '53', 'postcode' => '1047 GH', 'city' => 'Amsterdam'],
            ['street' => 'Zuidweg', 'house_number' => '14', 'postcode' => '1048 IJ', 'city' => 'Amsterdam'],
            ['street' => 'Bovenweg', 'house_number' => '92', 'postcode' => '1049 KL', 'city' => 'Amsterdam'],
            ['street' => 'Haringvliet', 'house_number' => '25', 'postcode' => '1050 MN', 'city' => 'Amsterdam'],
            ['street' => 'Marktplein', 'house_number' => '16', 'postcode' => '1051 OP', 'city' => 'Amsterdam'],
            ['street' => 'Dijkgraaf', 'house_number' => '32', 'postcode' => '1052 QR', 'city' => 'Amsterdam'],
            ['street' => 'Brouwerijstraat', 'house_number' => '19', 'postcode' => '1053 ST', 'city' => 'Amsterdam'],
            ['street' => 'Roosendaalstraat', 'house_number' => '60', 'postcode' => '1054 UV', 'city' => 'Amsterdam'],
            ['street' => 'Torenweg', 'house_number' => '47', 'postcode' => '1055 WX', 'city' => 'Amsterdam'],
            ['street' => 'Jan van Galenstraat', 'house_number' => '5', 'postcode' => '1056 YZ', 'city' => 'Amsterdam'],
            ['street' => 'De Waal', 'house_number' => '80', 'postcode' => '1057 AB', 'city' => 'Amsterdam'],
            ['street' => 'Laan van Spartaan', 'house_number' => '11', 'postcode' => '1058 CD', 'city' => 'Amsterdam'],
            ['street' => 'Willem de Zwijgerlaan', 'house_number' => '2', 'postcode' => '1059 EF', 'city' => 'Amsterdam'],
            ['street' => 'Molenbeek', 'house_number' => '44', 'postcode' => '1060 GH', 'city' => 'Amsterdam'],
            ['street' => 'Amstelstraat', 'house_number' => '7', 'postcode' => '1061 IJ', 'city' => 'Amsterdam'],
            ['street' => 'Willem van Oranjeweg', 'house_number' => '20', 'postcode' => '1062 KL', 'city' => 'Amsterdam'],
            ['street' => 'Noordwal', 'house_number' => '16', 'postcode' => '1063 MN', 'city' => 'Amsterdam'],
            ['street' => 'Leidsestraat', 'house_number' => '9', 'postcode' => '1064 OP', 'city' => 'Amsterdam'],
            ['street' => 'Torenstraat', 'house_number' => '77', 'postcode' => '1065 QR', 'city' => 'Amsterdam'],
            ['street' => 'Tijdstraat', 'house_number' => '21', 'postcode' => '1066 ST', 'city' => 'Amsterdam'],
            ['street' => 'Zonnestraat', 'house_number' => '38', 'postcode' => '1067 UV', 'city' => 'Amsterdam'],
            ['street' => 'Oostzijde', 'house_number' => '36', 'postcode' => '1068 WX', 'city' => 'Amsterdam'],
            ['street' => 'Westzijde', 'house_number' => '74', 'postcode' => '1069 YZ', 'city' => 'Amsterdam'],
            ['street' => 'Parelstraat', 'house_number' => '4', 'postcode' => '1070 AB', 'city' => 'Amsterdam'],
            ['street' => 'Rivierenweg', 'house_number' => '18', 'postcode' => '1071 CD', 'city' => 'Amsterdam'],
            ['street' => 'Havendijk', 'house_number' => '90', 'postcode' => '1072 EF', 'city' => 'Amsterdam'],
            ['street' => 'Molenring', 'house_number' => '5', 'postcode' => '1073 GH', 'city' => 'Amsterdam'],
            ['street' => 'Zuidkade', 'house_number' => '26', 'postcode' => '1074 IJ', 'city' => 'Amsterdam'],
            ['street' => 'Oostkade', 'house_number' => '34', 'postcode' => '1075 KL', 'city' => 'Amsterdam'],
            ['street' => 'Westkade', 'house_number' => '12', 'postcode' => '1076 MN', 'city' => 'Amsterdam'],
            ['street' => 'Noorderkade', 'house_number' => '48', 'postcode' => '1077 OP', 'city' => 'Amsterdam'],
            ['street' => 'Zuidweststraat', 'house_number' => '15', 'postcode' => '1078 QR', 'city' => 'Amsterdam'],
            ['street' => 'Kadeweg', 'house_number' => '33', 'postcode' => '1079 ST', 'city' => 'Amsterdam'],
            ['street' => 'Hoofdkade', 'house_number' => '29', 'postcode' => '1080 UV', 'city' => 'Amsterdam'],
            ['street' => 'Dijkweg', 'house_number' => '99', 'postcode' => '1081 WX', 'city' => 'Amsterdam'],
            ['street' => 'Lijnbaan', 'house_number' => '11', 'postcode' => '1082 YZ', 'city' => 'Amsterdam'],
            ['street' => 'Nijverheidstraat', 'house_number' => '43', 'postcode' => '1083 AB', 'city' => 'Amsterdam'],
            ['street' => 'Schoenerstraat', 'house_number' => '39', 'postcode' => '1084 CD', 'city' => 'Amsterdam'],
            ['street' => 'Grootzand', 'house_number' => '18', 'postcode' => '1085 EF', 'city' => 'Amsterdam'],
            ['street' => 'Breezand', 'house_number' => '60', 'postcode' => '1086 GH', 'city' => 'Amsterdam'],
            ['street' => 'Polderweg', 'house_number' => '45', 'postcode' => '1087 IJ', 'city' => 'Amsterdam'],
            ['street' => 'Vossenkade', 'house_number' => '27', 'postcode' => '1088 KL', 'city' => 'Amsterdam'],
            ['street' => 'Amsteldijk', 'house_number' => '88', 'postcode' => '1089 MN', 'city' => 'Amsterdam'],
            ['street' => 'Oostvogelstraat', 'house_number' => '37', 'postcode' => '1090 OP', 'city' => 'Amsterdam'],
            ['street' => 'Westvogelstraat', 'house_number' => '72', 'postcode' => '1091 QR', 'city' => 'Amsterdam'],
            ['street' => 'Zilverhoef', 'house_number' => '8', 'postcode' => '1092 ST', 'city' => 'Amsterdam'],
            ['street' => 'Aalsterveld', 'house_number' => '55', 'postcode' => '1093 UV', 'city' => 'Amsterdam'],
            ['street' => 'Veenhoef', 'house_number' => '33', 'postcode' => '1094 WX', 'city' => 'Amsterdam'],
            ['street' => 'Zandvoort', 'house_number' => '25', 'postcode' => '1095 YZ', 'city' => 'Amsterdam'],
            ['street' => 'Zilverzand', 'house_number' => '78', 'postcode' => '1096 AB', 'city' => 'Amsterdam'],
            ['street' => 'Beekdijk', 'house_number' => '90', 'postcode' => '1097 CD', 'city' => 'Amsterdam'],
            ['street' => 'Zonenkade', 'house_number' => '44', 'postcode' => '1098 EF', 'city' => 'Amsterdam'],
            ['street' => 'Ruisdijk', 'house_number' => '16', 'postcode' => '1099 GH', 'city' => 'Amsterdam'],
            ['street' => 'Horizonweg', 'house_number' => '20', 'postcode' => '1100 IJ', 'city' => 'Amsterdam'],
            ['street' => 'Avondrood', 'house_number' => '31', 'postcode' => '1101 KL', 'city' => 'Amsterdam'],
            ['street' => 'Dewerdijk', 'house_number' => '80', 'postcode' => '1102 MN', 'city' => 'Amsterdam'],
            ['street' => 'Zeeweg', 'house_number' => '90', 'postcode' => '1103 OP', 'city' => 'Amsterdam'],
            ['street' => 'Noorderbaan', 'house_number' => '22', 'postcode' => '1104 QR', 'city' => 'Amsterdam'],
            ['street' => 'Zuiderspoor', 'house_number' => '8', 'postcode' => '1105 ST', 'city' => 'Amsterdam'],
            ['street' => 'Groeneweg', 'house_number' => '75', 'postcode' => '1106 UV', 'city' => 'Amsterdam'],
            ['street' => 'Oostschans', 'house_number' => '41', 'postcode' => '1107 WX', 'city' => 'Amsterdam'],
            ['street' => 'Westeinde', 'house_number' => '90', 'postcode' => '1108 YZ', 'city' => 'Amsterdam'],
        ];
    }    
}
