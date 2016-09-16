<?php
/**
 * calculator.php
 * (C) 2006 Sjoerd Langkemper
 * Functions which parse a simple mathematical expression and calculate
 * the result.
 *
 * The function mathexp_to_rpn() converts a mathematical expression in 
 * infix notation, like "3 + 2" to an expression in reverse polish
 * notation (RPN): "3 2 +". This is easier to calculate, which is done
 * by the function calculate_rpn(). Operator precedence and parenthesis
 * is taken into account. There is no checking whether the input is
 * a valid expression. Dividing is not very precise.
 *
 * This file is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * You may use this file according to one of the following licenses:
 * - GNU General Public License, version 2 or higher
 *   <http://www.gnu.org/licenses/gpl.html>
 * - GNU Lesser General Public License, version 2.1 or higher
 *   <http://www.gnu.org/licenses/lgpl.html>
 * - Mozilla Public License, version 1.1 or higher
 *   <http://www.mozilla.org/MPL/>
 *
 * You are not required to accept any of the above licenses, since you have 
 * not signed any of them. However, nothing else grants you permission to 
 * modify or distribute this file or its derivative works. These actions 
 * are prohibited by law if you do not accept any of the above licenses.
 */
	
	// calculates the result of an expression in infix notation
	function calculate($exp) {
		return calculate_rpn(mathexp_to_rpn($exp));
	}

	// calculates the result of an expression in reverse polish notation
	function calculate_rpn($rpnexp) {
		$stack = array();
		foreach($rpnexp as $item) {
			if (is_operator($item)) {
				if ($item == '+') {
					$j = array_pop($stack);
					$i = array_pop($stack);
					array_push($stack, $i + $j);
				}
				if ($item == '-') {
					$j = array_pop($stack);
					$i = array_pop($stack);
					array_push($stack, $i - $j);
				}
				if ($item == '*') {
					$j = array_pop($stack);
					$i = array_pop($stack);
					array_push($stack, $i * $j);
				}
				if ($item == '/') {
					$j = array_pop($stack);
					$i = array_pop($stack);
					array_push($stack, $i / $j);
				}
				if ($item == '%') {
					$j = array_pop($stack);
					$i = array_pop($stack);
					array_push($stack, $i % $j);
				}
			} else {
				array_push($stack, $item);
			}
		}
		return $stack[0];
	}

	// converts infix notation to reverse polish notation
	function mathexp_to_rpn($mathexp) {
		$precedence = array(
			'(' => 0,
			'-' => 3,
			'+' => 3,
			'*' => 6,
			'/' => 6,
			'%' => 6
		);
	
		$i = 0;
		$final_stack = array();
		$operator_stack = array();

		while ($i < strlen($mathexp)) {
			$char = $mathexp{$i};
			if (is_number($char)) {
				$num = readnumber($mathexp, $i);
				array_push($final_stack, $num);
				$i += strlen($num); continue;
			}
			if (is_operator($char)) {
				$top = end($operator_stack);
				if ($top && $precedence[$char] <= $precedence[$top]) {
					$oper = array_pop($operator_stack);
					array_push($final_stack, $oper);
				}
				array_push($operator_stack, $char);
				$i++; continue;
			}
			if ($char == '(') {
				array_push($operator_stack, $char);
				$i++; continue;
			}
			if ($char == ')') {
				// transfer operators to final stack
				do {
					$operator = array_pop($operator_stack);
					if ($operator == '(') break;
					array_push($final_stack, $operator);
				} while ($operator);
				$i++; continue;
			}
			$i++;
		}
		while ($oper = array_pop($operator_stack)) {
			array_push($final_stack, $oper);
		}
		return $final_stack;
	}

	function readnumber($string, $i) {
		$number = '';
		while (is_number($string{$i})) {
			$number .= $string{$i};
			$i++;
		}
		return $number;
	}

	function is_operator($char) {
		static $operators = array('+', '-', '/', '*', '%');
		return in_array($char, $operators);
	}

	function is_number($char) {
		return (($char == '.') || ($char >= '0' && $char <= '9'));
	}
?>