
<?php

if (function_exists('sapi_windows_cp_set')) {
    sapi_windows_cp_set(65001);
}

echo "ЧЕГО СКАЗАТЬ-ТО ХОТЕЛ, МИЛОК?!\n";

$goodbyeCount = 0;

while (true) {
    $input = readline("> ");

    if ($input === false) {
        break;
    }

    if ($input === '') {
        continue;
    }

    if ($input === 'ПОКА!') {
        $goodbyeCount++;

        if ($goodbyeCount === 3) {
            echo "ДО СВИДАНИЯ, МИЛЫЙ!\n";
            break;
        }
    } else {
        $goodbyeCount = 0;
    }

    if (str_ends_with($input, '!')) {
        $year = random_int(1930, 1950);
        echo "НЕТ, НИ РАЗУ С $year ГОДА!\n";
    } else {
        echo "АСЬ?! ГОВОРИ ГРОМЧЕ, ВНУЧЕК!\n";
    }
}
