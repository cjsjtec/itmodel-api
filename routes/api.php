<?php

foreach (glob(__DIR__ . '/api/*/*.php') as $file) {
	require $file;
}