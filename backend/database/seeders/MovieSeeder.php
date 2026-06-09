<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $movies = [
            [
                'title' => 'Inception',
                'year' => 2010,
                'rating' => 8.8,
                'genres' => ['Sci-Fi', 'Thriller', 'Action'],
                'duration' => '2h 28m',
                'description' => 'A skilled thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O., but his tragic past may doom the project and his team to disaster.',
                'cast' => ['Leonardo DiCaprio', 'Joseph Gordon-Levitt', 'Elliot Page', 'Tom Hardy', 'Ken Watanabe'],
                'posterGradient' => 'linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%)',
            ],
            [
                'title' => 'The Dark Knight',
                'year' => 2008,
                'rating' => 9.0,
                'genres' => ['Action', 'Crime', 'Drama'],
                'duration' => '2h 32m',
                'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'cast' => ['Christian Bale', 'Heath Ledger', 'Aaron Eckhart', 'Michael Caine', 'Gary Oldman'],
                'posterGradient' => 'linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 50%, #2d2d2d 100%)',
            ],
            [
                'title' => 'Interstellar',
                'year' => 2014,
                'rating' => 8.6,
                'genres' => ['Sci-Fi', 'Adventure', 'Drama'],
                'duration' => '2h 49m',
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'cast' => ['Matthew McConaughey', 'Anne Hathaway', 'Jessica Chastain', 'Michael Caine', 'Matt Damon'],
                'posterGradient' => 'linear-gradient(135deg, #0a0a1a 0%, #1a1a3e 50%, #2d2d7e 100%)',
            ],
            [
                'title' => 'Parasite',
                'year' => 2019,
                'rating' => 8.5,
                'genres' => ['Drama', 'Thriller', 'Comedy'],
                'duration' => '2h 12m',
                'description' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.',
                'cast' => ['Kang-ho Song', 'Sun-kyun Lee', 'Yeo-jeong Cho', 'Woo-sik Choi', 'So-dam Park'],
                'posterGradient' => 'linear-gradient(135deg, #1a1a1a 0%, #2d1a2d 50%, #3d1a1a 100%)',
            ],
            [
                'title' => 'The Matrix',
                'year' => 1999,
                'rating' => 8.7,
                'genres' => ['Sci-Fi', 'Action'],
                'duration' => '2h 16m',
                'description' => 'A computer programmer discovers that reality as he knows it is a simulation created by machines, and joins a rebellion to break free.',
                'cast' => ['Keanu Reeves', 'Laurence Fishburne', 'Carrie-Anne Moss', 'Hugo Weaving', 'Joe Pantoliano'],
                'posterGradient' => 'linear-gradient(135deg, #001a00 0%, #003300 50%, #004d00 100%)',
            ],
            [
                'title' => 'Pulp Fiction',
                'year' => 1994,
                'rating' => 8.9,
                'genres' => ['Crime', 'Drama', 'Thriller'],
                'duration' => '2h 34m',
                'description' => 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of bandits intertwine in four tales of violence and redemption.',
                'cast' => ['John Travolta', 'Uma Thurman', 'Samuel L. Jackson', 'Bruce Willis', 'Harvey Keitel'],
                'posterGradient' => 'linear-gradient(135deg, #1a0a00 0%, #3d1a00 50%, #5d2a00 100%)',
            ],
            [
                'title' => 'The Grand Budapest Hotel',
                'year' => 2014,
                'rating' => 8.1,
                'genres' => ['Comedy', 'Drama', 'Adventure'],
                'duration' => '1h 39m',
                'description' => 'A writer encounters the owner of an aging European hotel between the wars and learns of his friendship with a young employee who becomes heir of a priceless painting.',
                'cast' => ['Ralph Fiennes', 'F. Murray Abraham', 'Mathieu Amalric', 'Adrien Brody', 'Jeff Goldblum'],
                'posterGradient' => 'linear-gradient(135deg, #2d0a1a 0%, #5d1a3d 50%, #8d2a5d 100%)',
            ],
            [
                'title' => 'Dune: Part Two',
                'year' => 2024,
                'rating' => 8.6,
                'genres' => ['Sci-Fi', 'Adventure', 'Action'],
                'duration' => '2h 47m',
                'description' => 'Paul Atreides unites with Chani and the Fremen while seeking revenge against the conspirators who destroyed his family.',
                'cast' => ['Timothée Chalamet', 'Zendaya', 'Rebecca Ferguson', 'Josh Brolin', 'Austin Butler'],
                'posterGradient' => 'linear-gradient(135deg, #1a1000 0%, #3d2600 50%, #5d3c00 100%)',
            ],
            [
                'title' => 'Spirited Away',
                'year' => 2001,
                'rating' => 8.6,
                'genres' => ['Fantasy', 'Adventure'],
                'duration' => '2h 5m',
                'description' => 'During her family\'s move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits.',
                'cast' => ['Daveigh Chase', 'Suzanne Pleshette', 'Miyu Irino', 'Rumi Hiiragi', 'Mari Natsuki'],
                'posterGradient' => 'linear-gradient(135deg, #001a2d 0%, #003d5d 50%, #005d8d 100%)',
            ],
            [
                'title' => 'Fight Club',
                'year' => 1999,
                'rating' => 8.8,
                'genres' => ['Drama', 'Thriller'],
                'duration' => '2h 19m',
                'description' => 'An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into much more.',
                'cast' => ['Brad Pitt', 'Edward Norton', 'Helena Bonham Carter', 'Meat Loaf', 'Jared Leto'],
                'posterGradient' => 'linear-gradient(135deg, #1a0000 0%, #3d0000 50%, #5d0000 100%)',
            ],
            [
                'title' => 'Gladiator',
                'year' => 2000,
                'rating' => 8.5,
                'genres' => ['Action', 'Adventure', 'Drama'],
                'duration' => '2h 35m',
                'description' => 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.',
                'cast' => ['Russell Crowe', 'Joaquin Phoenix', 'Connie Nielsen', 'Oliver Reed', 'Richard Harris'],
                'posterGradient' => 'linear-gradient(135deg, #1a0a00 0%, #3d1a00 50%, #5d2a00 100%)',
            ],
            [
                'title' => 'Avengers: Endgame',
                'year' => 2019,
                'rating' => 8.4,
                'genres' => ['Action', 'Adventure', 'Sci-Fi'],
                'duration' => '3h 1m',
                'description' => 'After the devastating events of Infinity War, the Avengers assemble once more to reverse Thanos\'s actions and restore balance to the universe.',
                'cast' => ['Robert Downey Jr.', 'Chris Evans', 'Mark Ruffalo', 'Chris Hemsworth', 'Scarlett Johansson'],
                'posterGradient' => 'linear-gradient(135deg, #0a0a1a 0%, #1a1a3d 50%, #2a2a5d 100%)',
            ],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
