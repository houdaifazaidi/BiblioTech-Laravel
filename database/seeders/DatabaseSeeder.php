<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. Admin ───────────────────────────────────────────────────────
        Admin::updateOrCreate(
            ['email' => 'admin@bibliotech.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // ─── 2. Members ─────────────────────────────────────────────────────
        $membersData = [
            ['name' => 'Alice Martin',    'email' => 'alice@example.com',   'phone' => '+212661001001', 'address' => '12 Rue Hassan II, Casablanca'],
            ['name' => 'Bob Dupont',      'email' => 'bob@example.com',     'phone' => '+212662002002', 'address' => '5 Avenue Mohamed V, Rabat'],
            ['name' => 'Chloe Bernard',   'email' => 'chloe@example.com',   'phone' => '+212663003003', 'address' => '8 Rue Ibn Khaldoun, Fès'],
            ['name' => 'David Moreau',    'email' => 'david@example.com',   'phone' => '+212664004004', 'address' => '3 Blvd Zerktouni, Casablanca'],
            ['name' => 'Emma Laurent',    'email' => 'emma@example.com',    'phone' => '+212665005005', 'address' => '20 Rue Allal Ben Abdellah, Marrakech'],
            ['name' => 'Fatima Zahra',    'email' => 'fatima@example.com',  'phone' => '+212666006006', 'address' => '7 Derb Soltane, Fès'],
            ['name' => 'Gabriel Petit',   'email' => 'gabriel@example.com', 'phone' => '+212667007007', 'address' => '15 Rue Patrice Lumumba, Tanger'],
            ['name' => 'Hana Benali',     'email' => 'hana@example.com',    'phone' => '+212668008008', 'address' => '9 Rue Abdelkrim Khattabi, Meknès'],
            ['name' => 'Ibrahim Khalil',  'email' => 'ibrahim@example.com', 'phone' => '+212669009009', 'address' => '11 Blvd Mohammed Zerktouni, Agadir'],
            ['name' => 'Julie Fontaine',  'email' => 'julie@example.com',   'phone' => '+212660010010', 'address' => '6 Rue Oued Souss, Agadir'],
        ];

        $members = [];
        foreach ($membersData as $data) {
            $members[] = Member::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['password' => Hash::make('password'), 'is_active' => 1])
            );
        }

        // ─── 3. Books ───────────────────────────────────────────────────────
        $booksData = [
            // Fiction
            ['title' => 'The Great Gatsby',          'author' => 'F. Scott Fitzgerald', 'isbn' => '9780743273565', 'publisher' => 'Scribner',        'published_year' => 1925, 'genre' => 'Fiction',     'description' => 'A story of wealth, love, and the American Dream in the 1920s.',           'total_copies' => 4, 'cover_image' => 'https://placehold.co/300x450/1a1a2e/e0e0ff?text=Great+Gatsby'],
            ['title' => 'To Kill a Mockingbird',     'author' => 'Harper Lee',           'isbn' => '9780061935466', 'publisher' => 'HarperCollins',   'published_year' => 1960, 'genre' => 'Fiction',     'description' => 'A gripping, heart-wrenching, and wholly remarkable tale of coming-of-age.',  'total_copies' => 5, 'cover_image' => 'https://placehold.co/300x450/1a1a2e/e0e0ff?text=Mockingbird'],
            ['title' => '1984',                      'author' => 'George Orwell',        'isbn' => '9780451524935', 'publisher' => 'Signet Classic',  'published_year' => 1949, 'genre' => 'Fiction',     'description' => 'A dystopian novel about totalitarianism, surveillance, and repression.',      'total_copies' => 6, 'cover_image' => 'https://placehold.co/300x450/1a1a2e/e0e0ff?text=1984'],
            ['title' => 'Brave New World',           'author' => 'Aldous Huxley',        'isbn' => '9780060850524', 'publisher' => 'Harper Perennial','published_year' => 1932, 'genre' => 'Fiction',     'description' => 'A futuristic society built on technological control and pleasure.',            'total_copies' => 3, 'cover_image' => 'https://placehold.co/300x450/1a1a2e/e0e0ff?text=Brave+New+World'],
            // Science
            ['title' => 'A Brief History of Time',  'author' => 'Stephen Hawking',      'isbn' => '9780553380163', 'publisher' => 'Bantam Books',    'published_year' => 1988, 'genre' => 'Science',     'description' => 'An exploration of the universe, from the Big Bang to black holes.',            'total_copies' => 4, 'cover_image' => 'https://placehold.co/300x450/162032/b0d4ff?text=Brief+History'],
            ['title' => 'The Selfish Gene',          'author' => 'Richard Dawkins',      'isbn' => '9780198788607', 'publisher' => 'Oxford UP',       'published_year' => 1976, 'genre' => 'Science',     'description' => 'A groundbreaking work on evolution from a gene-centric perspective.',           'total_copies' => 3, 'cover_image' => 'https://placehold.co/300x450/162032/b0d4ff?text=Selfish+Gene'],
            ['title' => 'Cosmos',                    'author' => 'Carl Sagan',           'isbn' => '9780345331359', 'publisher' => 'Ballantine Books','published_year' => 1980, 'genre' => 'Science',     'description' => 'A journey through the universe and the history of astronomy.',                  'total_copies' => 2, 'cover_image' => 'https://placehold.co/300x450/162032/b0d4ff?text=Cosmos'],
            // History
            ['title' => 'Sapiens',                   'author' => 'Yuval Noah Harari',    'isbn' => '9780062316097', 'publisher' => 'Harper',          'published_year' => 2011, 'genre' => 'History',     'description' => 'A brief history of humankind, from prehistoric times to the modern era.',      'total_copies' => 5, 'cover_image' => 'https://placehold.co/300x450/1e1a0e/ffd0a0?text=Sapiens'],
            ['title' => 'Guns, Germs, and Steel',   'author' => 'Jared Diamond',        'isbn' => '9780393354324', 'publisher' => 'W. W. Norton',    'published_year' => 1997, 'genre' => 'History',     'description' => 'Why some civilizations dominate and others are dominated.',                     'total_copies' => 3, 'cover_image' => 'https://placehold.co/300x450/1e1a0e/ffd0a0?text=Guns+Germs'],
            ['title' => 'The Silk Roads',            'author' => 'Peter Frankopan',      'isbn' => '9781101912379', 'publisher' => 'Vintage',         'published_year' => 2015, 'genre' => 'History',     'description' => 'A new history of the world told through the lens of trade routes.',             'total_copies' => 2, 'cover_image' => 'https://placehold.co/300x450/1e1a0e/ffd0a0?text=Silk+Roads'],
            // Technology
            ['title' => 'Clean Code',                'author' => 'Robert C. Martin',     'isbn' => '9780132350884', 'publisher' => 'Prentice Hall',   'published_year' => 2008, 'genre' => 'Technology',  'description' => 'A handbook of agile software craftsmanship and best coding practices.',        'total_copies' => 4, 'cover_image' => 'https://placehold.co/300x450/0e1e1a/a0ffdb?text=Clean+Code'],
            ['title' => 'The Pragmatic Programmer',  'author' => 'Andrew Hunt',          'isbn' => '9780135957059', 'publisher' => 'Addison-Wesley',  'published_year' => 2019, 'genre' => 'Technology',  'description' => 'From journeyman to master — timeless lessons for software developers.',        'total_copies' => 3, 'cover_image' => 'https://placehold.co/300x450/0e1e1a/a0ffdb?text=Pragmatic'],
            ['title' => 'Zero to One',               'author' => 'Peter Thiel',          'isbn' => '9780804139021', 'publisher' => 'Crown Business',  'published_year' => 2014, 'genre' => 'Technology',  'description' => 'Notes on startups, or how to build the future.',                              'total_copies' => 3, 'cover_image' => 'https://placehold.co/300x450/0e1e1a/a0ffdb?text=Zero+to+One'],
            // Philosophy
            ['title' => 'Meditations',               'author' => 'Marcus Aurelius',      'isbn' => '9780812968255', 'publisher' => 'Modern Library',  'published_year' => null,  'genre' => 'Philosophy',  'description' => 'Personal writings of the Roman Emperor, a Stoic masterpiece.',                 'total_copies' => 5, 'cover_image' => 'https://placehold.co/300x450/1e0e1e/e0a0ff?text=Meditations'],
            ['title' => 'The Republic',              'author' => 'Plato',                'isbn' => '9780872201361', 'publisher' => 'Hackett',         'published_year' => null, 'genre' => 'Philosophy',  'description' => 'Plato\'s dialogue on justice, beauty, equality, and the ideal state.',         'total_copies' => 2, 'cover_image' => 'https://placehold.co/300x450/1e0e1e/e0a0ff?text=The+Republic'],
            // Mystery
            ['title' => 'The Name of the Rose',      'author' => 'Umberto Eco',          'isbn' => '9780544176492', 'publisher' => 'Houghton Mifflin','published_year' => 1980, 'genre' => 'Mystery',     'description' => 'A medieval mystery set in an Italian abbey, full of intrigue and philosophy.',  'total_copies' => 3, 'cover_image' => 'https://placehold.co/300x450/1a0e0e/ffb0b0?text=Name+of+Rose'],
            ['title' => 'And Then There Were None',  'author' => 'Agatha Christie',      'isbn' => '9780062073488', 'publisher' => 'HarperCollins',   'published_year' => 1939, 'genre' => 'Mystery',     'description' => 'Ten strangers summoned to an island — one by one, they begin to die.',          'total_copies' => 4, 'cover_image' => 'https://placehold.co/300x450/1a0e0e/ffb0b0?text=Then+There+Were+None'],
            // Self-Help
            ['title' => 'Atomic Habits',             'author' => 'James Clear',          'isbn' => '9780735211292', 'publisher' => 'Avery',           'published_year' => 2018, 'genre' => 'Self-Help',   'description' => 'An easy and proven way to build good habits and break bad ones.',               'total_copies' => 6, 'cover_image' => 'https://placehold.co/300x450/0e1a0e/b0ffb0?text=Atomic+Habits'],
            ['title' => 'Man\'s Search for Meaning', 'author' => 'Viktor E. Frankl',     'isbn' => '9780807014271', 'publisher' => 'Beacon Press',    'published_year' => 1946, 'genre' => 'Self-Help',   'description' => 'A psychiatrist\'s experience in Nazi concentration camps and finding purpose.',  'total_copies' => 4, 'cover_image' => 'https://placehold.co/300x450/0e1a0e/b0ffb0?text=Mans+Search'],
            ['title' => 'Think and Grow Rich',       'author' => 'Napoleon Hill',        'isbn' => '9781585424337', 'publisher' => 'TarcherPerigee',  'published_year' => 1937, 'genre' => 'Self-Help',   'description' => 'Classic principles of personal success and financial achievement.',              'total_copies' => 3, 'cover_image' => 'https://placehold.co/300x450/0e1a0e/b0ffb0?text=Think+Grow+Rich'],
        ];

        $books = [];
        foreach ($booksData as $data) {
            $books[] = Book::updateOrCreate(
                ['isbn' => $data['isbn']],
                array_merge($data, ['available_copies' => $data['total_copies']])
            );
        }

        // ─── 4. Loans (some overdue, some active) ───────────────────────────
        $loansData = [
            // Active (not overdue)
            [
                'member_id'   => $members[0]->id,
                'book_id'     => $books[0]->id, // The Great Gatsby → Alice
                'borrowed_at' => now()->subDays(5),
                'due_date'    => now()->addDays(9)->toDateString(),
                'status'      => 'active',
            ],
            [
                'member_id'   => $members[1]->id,
                'book_id'     => $books[10]->id, // Clean Code → Bob
                'borrowed_at' => now()->subDays(3),
                'due_date'    => now()->addDays(11)->toDateString(),
                'status'      => 'active',
            ],
            // Overdue loans (due_date in past)
            [
                'member_id'     => $members[2]->id,
                'book_id'       => $books[7]->id, // Sapiens → Chloe (10 days overdue)
                'borrowed_at'   => now()->subDays(24),
                'due_date'      => now()->subDays(10)->toDateString(),
                'status'        => 'overdue',
                'penalty_amount' => 40.00, // 8 days overdue × 5.00 (after 2 grace days)
            ],
            [
                'member_id'     => $members[3]->id,
                'book_id'       => $books[4]->id, // Brief History → David (7 days overdue)
                'borrowed_at'   => now()->subDays(21),
                'due_date'      => now()->subDays(7)->toDateString(),
                'status'        => 'overdue',
                'penalty_amount' => 25.00, // 5 days overdue × 5.00 (after 2 grace days)
            ],
            [
                'member_id'     => $members[4]->id,
                'book_id'       => $books[13]->id, // Meditations → Emma (20 days overdue)
                'borrowed_at'   => now()->subDays(34),
                'due_date'      => now()->subDays(20)->toDateString(),
                'status'        => 'overdue',
                'penalty_amount' => 90.00, // 18 days overdue × 5.00 = 90.00 (capped at 200)
            ],
        ];

        foreach ($loansData as $loanData) {
            // Check not already existing
            $exists = Loan::where('member_id', $loanData['member_id'])
                ->where('book_id', $loanData['book_id'])
                ->whereNull('returned_at')
                ->exists();

            if (!$exists) {
                Loan::create($loanData);
                // Decrement available_copies
                Book::where('id', $loanData['book_id'])->decrement('available_copies');
            }
        }

        $this->command->info('✓ BiblioTech seeded: 1 admin, 10 members, 20 books, 5 loans.');
    }
}
