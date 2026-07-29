<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new ProController())->index(),
    'deletePro' => (new ProController())->deletePro(),
    'showAddForm' => (new AddController())->showForm(),
    'addPro' => (new AddController())->addPro(),
    'showEditForm' => (new UpdateController())->showForm(),
    'editPro' => (new UpdateController())->updatePro(),
    default => (new ProController())->index(),
};