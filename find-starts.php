#!/usr/bin/env php
<?php

const PACKET_LENGTH = 188;
$offset = 0;
while (!feof(STDIN)) {
	$packet = fread(STDIN, PACKET_LENGTH);
	if ('' === $packet) {
		break;
	}
	if (0x40 & ord($packet[1])) {
		$pid = 0x1fff & (ord($packet[1]) << 8) | ord($packet[2]);
		if (0 === $pid) {
			echo "$offset\n";
		}
	}
	
	$offset += PACKET_LENGTH;
}


// vim: set ts=4 noet ai
