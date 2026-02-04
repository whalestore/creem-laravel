<?php

use Creem\Data\Entities\PaginationEntity;

test('pagination entity can be created from array', function () {
    $data = [
        'total_records' => 100,
        'total_pages' => 10,
        'current_page' => 1,
        'next_page' => 2,
    ];

    $pagination = PaginationEntity::from($data);

    expect($pagination->totalRecords)->toBe(100);
    expect($pagination->totalPages)->toBe(10);
    expect($pagination->currentPage)->toBe(1);
    expect($pagination->nextPage)->toBe(2);
    expect($pagination->prevPage)->toBeNull();
});

test('pagination entity handles middle page', function () {
    $data = [
        'total_records' => 100,
        'total_pages' => 10,
        'current_page' => 5,
        'next_page' => 6,
        'prev_page' => 4,
    ];

    $pagination = PaginationEntity::from($data);

    expect($pagination->currentPage)->toBe(5);
    expect($pagination->nextPage)->toBe(6);
    expect($pagination->prevPage)->toBe(4);
});

test('pagination entity handles last page', function () {
    $data = [
        'total_records' => 100,
        'total_pages' => 10,
        'current_page' => 10,
        'prev_page' => 9,
    ];

    $pagination = PaginationEntity::from($data);

    expect($pagination->currentPage)->toBe(10);
    expect($pagination->nextPage)->toBeNull();
    expect($pagination->prevPage)->toBe(9);
});
