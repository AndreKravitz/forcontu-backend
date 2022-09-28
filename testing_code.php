<?php

function suma_infinita(...$params) {
    $suma = 0;

    foreach ($params as $numero) {
        $suma += $numero;
    };

    echo "la sumatoria es: $suma \n";

}

suma_infinita(1, 2);
suma_infinita(1, 2, 3);
suma_infinita(1, 2, 3, 4);

echo "\n";