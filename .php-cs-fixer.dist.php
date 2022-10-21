<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:3.8.0|configurator
 * you can change this configuration by importing this file.
 */
$config = new PhpCsFixer\Config();
return $config
	->setFinder(PhpCsFixer\Finder::create()
		->ignoreVCSIgnored(true)
		->in(__DIR__)
	)
	->setRiskyAllowed(true)
	->setIndent("\t")
	->setRules([
		'align_multiline_comment' => true,
		'array_indentation' => true,
		'array_push' => true,
		'array_syntax' => true,
		'assign_null_coalescing_to_coalesce_equal' => true,
		'binary_operator_spaces' => true,
		'blank_line_after_namespace' => true,
		'blank_line_before_statement' => true,
		'braces' => ['allow_single_line_closure' => true],
		'cast_spaces' => true,
		'class_definition' => true,
		'class_reference_name_casing' => true,
		'clean_namespace' => true,
		'combine_consecutive_issets' => true,
		'combine_consecutive_unsets' => true,
		'combine_nested_dirname' => true,
		'compact_nullable_typehint' => true,
		'concat_space' => ['spacing' => 'one'],
		'constant_case' => true,
		'control_structure_continuation_position' => true,
		'declare_equal_normalize' => true,
		'declare_parentheses' => true,
		'declare_strict_types' => true,
		'dir_constant' => true,
		'elseif' => true,
		'encoding' => true,
		'full_opening_tag' => true,
		'fully_qualified_strict_types' => true,
		'function_declaration' => ['trailing_comma_single_line' => true],
		'function_to_constant' => true,
		'function_typehint_space' => true,
		'get_class_to_class_keyword' => true,
		'global_namespace_import' => true,
		'indentation_type' => true,
		'integer_literal_case' => true,
		'is_null' => true,
		'lambda_not_used_import' => true,
		'line_ending' => true,
		'linebreak_after_opening_tag' => true,
		'list_syntax' => true,
		'logical_operators' => true,
		'lowercase_cast' => true,
		'lowercase_keywords' => true,
		'lowercase_static_reference' => true,
		'magic_constant_casing' => true,
		'magic_method_casing' => true,
		'method_argument_space' => true,
		'method_chaining_indentation' => true,
		'modernize_strpos' => true,
		'modernize_types_casting' => true,
		'multiline_comment_opening_closing' => true,
		'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
		'native_function_casing' => true,
		'native_function_type_declaration_casing' => true,
		'new_with_braces' => ['anonymous_class' => false],
		'no_alias_language_construct_call' => true,
		'no_blank_lines_after_class_opening' => true,
		'no_blank_lines_after_phpdoc' => true,
		'no_closing_tag' => true,
		'no_empty_phpdoc' => true,
		'no_empty_statement' => true,
		'no_extra_blank_lines' => ['tokens' => ['break', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'return', 'square_brace_block', 'switch', 'throw', 'use', 'use_trait']],
		'no_leading_import_slash' => true,
		'no_leading_namespace_whitespace' => true,
		'no_multiline_whitespace_around_double_arrow' => true,
		'no_short_bool_cast' => true,
		'no_singleline_whitespace_before_semicolons' => true,
		'no_space_around_double_colon' => true,
		'no_spaces_after_function_name' => true,
		'no_spaces_around_offset' => true,
		'no_spaces_inside_parenthesis' => true,
		'no_superfluous_elseif' => true,
		'no_trailing_comma_in_singleline_array' => true,
		'no_trailing_comma_in_singleline_function_call' => true,
		'no_trailing_whitespace' => true,
		'no_trailing_whitespace_in_comment' => true,
		'no_unneeded_control_parentheses' => ['statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield', 'yield_from']],
		'no_unneeded_import_alias' => true,
		'no_unset_cast' => true,
		'no_unused_imports' => true,
		'no_useless_else' => true,
		'no_useless_return' => true,
		'no_useless_sprintf' => true,
		'no_whitespace_before_comma_in_array' => ['after_heredoc' => true],
		'no_whitespace_in_blank_line' => true,
		'non_printable_character' => true,
		'normalize_index_brace' => true,
		'nullable_type_declaration_for_default_null_value' => true,
		'object_operator_without_whitespace' => true,
		'octal_notation' => true,
		'operator_linebreak' => ['only_booleans' => true, 'position' => 'end'],
		'php_unit_construct' => true,
		'php_unit_dedicate_assert' => true,
		'php_unit_dedicate_assert_internal_type' => true,
		'php_unit_expectation' => true,
		'php_unit_internal_class' => true,
		'php_unit_method_casing' => true,
		'php_unit_test_case_static_method_calls' => true,
		'phpdoc_add_missing_param_annotation' => ['only_untyped' => true],
		'phpdoc_align' => ['align' => 'left', 'tags' => ['method', 'param', 'property', 'property-read', 'property-write', 'return', 'throws', 'type', 'var']],
		'phpdoc_indent' => true,
		'phpdoc_line_span' => true,
		'phpdoc_no_alias_tag' => true,
		'phpdoc_no_useless_inheritdoc' => true,
		'phpdoc_scalar' => true,
		'phpdoc_separation' => true,
		'phpdoc_single_line_var_spacing' => true,
		'phpdoc_trim' => true,
		'return_assignment' => true,
		'return_type_declaration' => true,
		'self_static_accessor' => true,
		'semicolon_after_instruction' => true,
		'short_scalar_cast' => true,
		'simple_to_complex_string_variable' => true,
		'simplified_if_return' => true,
		'single_blank_line_at_eof' => true,
		'single_blank_line_before_namespace' => true,
		'single_class_element_per_statement' => true,
		'single_import_per_statement' => true,
		'single_line_after_imports' => true,
		'single_line_comment_spacing' => true,
		'single_quote' => true,
		'single_space_after_construct' => true,
		'single_trait_insert_per_statement' => true,
		'space_after_semicolon' => ['remove_in_empty_for_expressions' => true],
		'standardize_increment' => true,
		'standardize_not_equals' => true,
		'static_lambda' => true,
		'strict_param' => true,
		'string_length_to_empty' => true,
		'switch_case_semicolon_to_colon' => true,
		'switch_case_space' => true,
		'switch_continue_to_break' => true,
		'ternary_operator_spaces' => true,
		'ternary_to_elvis_operator' => true,
		'ternary_to_null_coalescing' => true,
		'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => ['arguments', 'arrays', 'parameters']],
		'trim_array_spaces' => true,
		'types_spaces' => ['space' => 'none'],
		'unary_operator_spaces' => true,
		'use_arrow_functions' => true,
		'visibility_required' => true,
		'void_return' => true,
		'yoda_style' => ['always_move_variable' => false, 'equal' => false, 'identical' => false, 'less_and_greater' => false],
	])
;
