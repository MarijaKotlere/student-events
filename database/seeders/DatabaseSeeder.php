<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Keyword;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Registration;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Users
        |--------------------------------------------------------------------------
        | Izveidojam divus lietotājus:
        | - administratoru
        | - parastu studentu
        */

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Categories
        |--------------------------------------------------------------------------
        | Kategorijas ir pievienotas kā atsevišķs datu reģistrs.
        | Tas ir svarīgi pēc pasniedzēja komentāra, jo administrators vēlāk
        | varēs pārvaldīt kategorijas.
        */

        $studyCategory = Category::create([
            'name' => 'Study',
            'description' => 'Educational and academic student events.',
        ]);

        $sportCategory = Category::create([
            'name' => 'Sports',
            'description' => 'Sport and active lifestyle events for students.',
        ]);

        $cultureCategory = Category::create([
            'name' => 'Culture',
            'description' => 'Cultural, creative and artistic student events.',
        ]);

        $socialCategory = Category::create([
            'name' => 'Social',
            'description' => 'Informal student meetings and social events.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. Events
        |--------------------------------------------------------------------------
        | Izveidojam vairākus pasākumus.
        | Katram pasākumam ir autors user_id un kategorija category_id.
        */

        $event1 = Event::create([
            'title' => 'Student Study Workshop',
            'description' => 'A workshop where students can study together and prepare for exams.',
            'event_date' => Carbon::now()->addDays(7),
            'location' => 'University Library',
            'max_participants' => 30,
            'user_id' => $admin->id,
            'category_id' => $studyCategory->id,
        ]);

        $event2 = Event::create([
            'title' => 'Football Evening',
            'description' => 'An evening football activity for students who enjoy sport.',
            'event_date' => Carbon::now()->addDays(10),
            'location' => 'University Stadium',
            'max_participants' => 22,
            'user_id' => $student->id,
            'category_id' => $sportCategory->id,
        ]);

        $event3 = Event::create([
            'title' => 'Student Culture Night',
            'description' => 'A cultural evening with music, presentations and student performances.',
            'event_date' => Carbon::now()->addDays(14),
            'location' => 'Main Hall',
            'max_participants' => 100,
            'user_id' => $admin->id,
            'category_id' => $cultureCategory->id,
        ]);

        $event4 = Event::create([
            'title' => 'Student Networking Meetup',
            'description' => 'A social meetup where students can meet new people and exchange ideas.',
            'event_date' => Carbon::now()->addDays(20),
            'location' => 'Student Centre',
            'max_participants' => 50,
            'user_id' => $student->id,
            'category_id' => $socialCategory->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4. Keywords
        |--------------------------------------------------------------------------
        | Atslēgvārdi palīdzēs vēlāk meklēt pasākumus.
        */

        $keywordStudents = Keyword::create([
            'name' => 'students',
        ]);

        $keywordEducation = Keyword::create([
            'name' => 'education',
        ]);

        $keywordSport = Keyword::create([
            'name' => 'sport',
        ]);

        $keywordMusic = Keyword::create([
            'name' => 'music',
        ]);

        $keywordNetworking = Keyword::create([
            'name' => 'networking',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5. Attach keywords to events
        |--------------------------------------------------------------------------
        | Vienam pasākumam var būt vairāki atslēgvārdi.
        */

        $event1->keywords()->attach([
            $keywordStudents->id,
            $keywordEducation->id,
        ]);

        $event2->keywords()->attach([
            $keywordStudents->id,
            $keywordSport->id,
        ]);

        $event3->keywords()->attach([
            $keywordStudents->id,
            $keywordMusic->id,
        ]);

        $event4->keywords()->attach([
            $keywordStudents->id,
            $keywordNetworking->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 6. Comments
        |--------------------------------------------------------------------------
        | Komentāri ir saistīti ar lietotāju un pasākumu.
        */

        Comment::create([
            'content' => 'This event looks very useful for exam preparation.',
            'user_id' => $student->id,
            'event_id' => $event1->id,
        ]);

        Comment::create([
            'content' => 'I would like to join this activity.',
            'user_id' => $admin->id,
            'event_id' => $event2->id,
        ]);

        Comment::create([
            'content' => 'This sounds like a good opportunity to meet other students.',
            'user_id' => $student->id,
            'event_id' => $event4->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 7. Ratings
        |--------------------------------------------------------------------------
        | Novērtējumi ir saistīti ar lietotāju un pasākumu.
        */

        Rating::create([
            'score' => 5,
            'user_id' => $student->id,
            'event_id' => $event1->id,
        ]);

        Rating::create([
            'score' => 4,
            'user_id' => $admin->id,
            'event_id' => $event2->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 8. Registrations
        |--------------------------------------------------------------------------
        | Pierakstīšanās ļauj lietotājam pieteikties pasākumam.
        */

        Registration::create([
            'user_id' => $student->id,
            'event_id' => $event1->id,
            'registered_at' => now(),
        ]);

        Registration::create([
            'user_id' => $admin->id,
            'event_id' => $event2->id,
            'registered_at' => now(),
        ]);

        Registration::create([
            'user_id' => $student->id,
            'event_id' => $event3->id,
            'registered_at' => now(),
        ]);
    }
}