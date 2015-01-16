<?php

Class extension_markdown_guide extends Extension {
  
	// Simply outputs information to Symphony about the extension
	public function about() {
		$info = array(
			'author' => array(
				'email' => 'stuart@eyes-down.net',
				'name' => 'Stuart Palmer, Carson Sasser',
				'website' => 'http://www.eyes-down.net'
			),
			'name' => 'Markdown Guide',
			'release-date' => '2014-11-12',
			'version' => '1.6'
		);
		return $info;
	}
	
	public function getSubscribedDelegates() {
		return array(
			array(
			'page' => '/backend/',
			'delegate' => 'ModifyTextareaFieldPublishWidget',
			'callback' => 'addGuideBelowTextArea'
			),
			array(
			'page' => '/backend/',
			'delegate' => 'InitaliseAdminPageHead',
			'callback' => 'initaliseAdminPageHead'
			)
		);
	}
	
	public function addGuideBelowTextArea($context) {
		//only show guide when using markdown
		$formatter = $context['field']->get('formatter');
		$pattern = '/^markdown/';
		if (!preg_match($pattern, $formatter)) return;

		//append the textarea here so the guide will show after the textarea in the form
		$context['label']->appendChild($context['textarea']);

		//nullify the textarea to prevent another one being appended in field.textarea.php
		$context['textarea'] = Widget::Label('');

		//retrieve the guide and append it
		if (file_exists(EXTENSIONS . '/markdown_guide/assets/' . $formatter . '.php')) {
			$file = EXTENSIONS . '/markdown_guide/assets/' . $formatter . '.php';
		} else {
			$file = EXTENSIONS . '/markdown_guide/assets/markdown.php';
		}
		
		include($file);
		
		foreach($description as $line) {
			$contents .= "<strong>{$line[0]}:</strong> {$line[1]}<br />";
		}
		
		$guide = Widget::Label($contents, null, 'markdown_guide');
		$context['label']->appendChild($guide);
	}

	public function initaliseAdminPageHead($context) {
		$page = Administration::instance()->Page;
		$page->addScriptToHead(URL . '/extensions/markdown_guide/assets/toggle_guide.js', 900200);
	}
}

?>
