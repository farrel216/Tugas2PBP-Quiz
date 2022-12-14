<?php
// Variabel time limit untuk membatasi lama kuis
$timeLimitSec = 5 * 60;

/* Pertanyaan dan jawabannya. Dalam bentuk 
   array of [
        assosiative array of [
            questions: string,
            answers: assosiative array of [id: integer, content: string],
            trueAnswer: integer 
        ]
   ]
*/
$questions = [
    [
        'question' => 'PHP Merupakan singkatan dari?',
        'answers' => [
            [
                'id' => 1,
                'content' => 'Private Home Page'
            ],
            [
                'id' => 2,
                'content' => 'Personal Hypertext Processor'
            ],
            [
                'id' => 3,
                'content' => 'PHP: Hypertext Processor'
            ],
            [
                'id' => 4,
                'content' => 'Program Hypertext Processor'
            ]
        ],
        'trueAnswer' => 3
    ],
    [
        'question' => 'Kode PHP diawali dan di akhiri dengan tanda?',
        'answers' => [
            [
                'id' => 1,
                'content' => '&lt;?php> .&lt;/?php&gt;'
            ],
            [
                'id' => 2,
                'content' => '&lt;script> … &lt;/script&gt;'
            ],
            [
                'id' => 3,
                'content' => '&lt;?php … ?&gt;'
            ],
            [
                'id' => 4,
                'content' => '&lt;php … /?&gt;'
            ]
        ],
        'trueAnswer' => 3
    ],
    [
        'question' => 'Sintak untuk mencetak output "Hello World" di PHP?',
        'answers' => [
            [
                'id' => 1,
                'content' => 'cout<<“Hello World”;'
            ],
            [
                'id' => 2,
                'content' => 'System.out.print(“Hello World”);'
            ],
            [
                'id' => 3,
                'content' => 'document.write (“Hello World”)'
            ],
            [
                'id' => 4,
                'content' => 'echo “Hello World”;'
            ]
        ],  
        'trueAnswer' => 4
    ],
    [
        'question' => 'Setiap variabel di PHP diawali dengan simbol?',
        'answers' => [
            [
                'id' => 1,
                'content' => '#'
            ],
            [
                'id' => 2,
                'content' => '$'
            ],
            [
                'id' => 3,
                'content' => '%'
            ],
            [
                'id' => 4,
                'content' => '*'
            ]
        ],
        'trueAnswer' => 2
    ],
    [
        'question' => 'Setiap perintah dalam PHP diakhiri dengan tanda?',
        'answers' => [
            [
                'id' => 1,
                'content' => ':'
            ],
            [
                'id' => 2,
                'content' => ';'
            ],
            [
                'id' => 3,
                'content' => '*'
            ],
            [
                'id' => 4,
                'content' => '&lt;/php&gt'
            ]
        ],
        'trueAnswer' => 2
    ],
    [
        'question' => 'Untuk membuat komentar di PHP menggunakan tanda?',
        'answers' => [
            [
                'id' => 1,
                'content' => '//'
            ],
            [
                'id' => 2,
                'content' => '/*'
            ],
            [
                'id' => 3,
                'content' => '%'
            ],
            [
                'id' => 4,
                'content' => '$'
            ]
        ],
        'trueAnswer' => 1
    ],
    [
        'question' => 'Tipe data integer di PHP digunakan untuk data?',
        'answers' => [
            [
                'id' => 1,
                'content' => 'Bilangan bulat'
            ],
            [
                'id' => 2,
                'content' => 'Bilangan Pecahan'
            ],
            [
                'id' => 3,
                'content' => 'Boolean'
            ],
            [
                'id' => 4,
                'content' => 'NULL'
            ]
        ],
        'trueAnswer' => 1
    ],
    [
        'question' => '"Tipe data Boolean hanya memiliki nilai true dan false!" Pernyataan ini...',
        'answers' => [
            [
                'id' => 1,
                'content' => 'Benar'
            ],
            [
                'id' => 2,
                'content' => 'Salah'
            ],
            [
                'id' => 3,
                'content' => 'Jawaban a dan b benar'
            ],
            [
                'id' => 4,
                'content' => 'Tidak diketahui'
            ]
        ],
        'trueAnswer' => 1
    ],
    [
        'question' => 'Operator aritmatika digunakan untuk melakukan operasi?',
        'answers' => [
            [
                'id' => 1,
                'content' => 'Aritmatika'
            ],
            [
                'id' => 2,
                'content' => 'Pembanding'
            ],
            [
                'id' => 3,
                'content' => 'Relasi'
            ],
            [
                'id' => 4,
                'content' => 'Assignment'
            ]
        ],
        'trueAnswer' => 1
    ],
    [
        'question' => '1Berikut ini contoh operator aritmatika, kecuali',
        'answers' => [
            [
                'id' => 1,
                'content' => '+'
            ],
            [
                'id' => 2,
                'content' => '%'
            ],
            [
                'id' => 3,
                'content' => '>='
            ],
            [
                'id' => 4,
                'content' => '/'
            ]
        ],
        'trueAnswer' => 3
    ]
    ];
?>