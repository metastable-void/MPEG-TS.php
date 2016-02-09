#!/usr/bin/env php
<?php

const PACKET_LENGTH = 188;
$offset = 0;
while (!feof(STDIN)) {
	$packet = fread(STDIN, PACKET_LENGTH);
	if ('' === $packet) {
		break;
	}
	echo "$offset";
	$pid = 0x1fff & (ord($packet[1]) << 8) | ord($packet[2]);
	$ccounter = 0xf & ord($packet[3]);
	echo "\tPID=$pid\t#$ccounter";
	if (0x20 & ord($packet[3])) {
		$adaptationLength = ord($packet[4]);
		echo "\t(adaptation=$adaptationLength)";
		if (0x40 & ord($packet[5])) {
			echo "\t(random access)";
		}
	}
	if (0x40 & ord($packet[1])) {
		echo "\t(Payload Unit Start)";
	}
	if (!(0x10 & ord($packet[3]))) {
			echo "\t(empty)";
	}
	echo PHP_EOL;
	
	$offset += PACKET_LENGTH;
}


// vim: set ts=4 noet ai
