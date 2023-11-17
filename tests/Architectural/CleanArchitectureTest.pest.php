<?php

test('the codebase does not contain debug statements')
	->expect(['dd', 'dump', 'var_dump', 'ddd', 'print_r', 'die', 'print'])
	->not->toBeUsed();

test('the codebase does not contain compact to return data from controller to view')
	->expect(['compact'])
	->not->toBeUsed();

test('the models folder contains classes', function () {
	expect('App\Models')
		->toBeClasses();
});

test('ValueObjects are immutable and cannot be modified at runtime')
	->expect('App\ValueObjects')
	->toBeReadonly();