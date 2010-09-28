<?php

Class extension_markdown_guide extends Extension {
  
	// Simply outputs information to Symphony about the extension
	public function about() {
		$info = array(
			'author' => array(
				'email' => 'sassercw@cox.net',
				'name' => 'Carson Sasser',
				'website' => 'http://carsonsasser.com/'
			),
			'name' => 'Markdown Guide',
			'release-date' => '2010-04-20',
			'version' => '1.1'
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
		switch($formatter){
			case 'markdown':
				$file = EXTENSIONS . '/markdown_guide/assets/markdown.php';
			break;
			case 'markdown_extra':
				$file = EXTENSIONS . '/markdown_guide/assets/markdown_extra.php';
			break;
			case 'markdown_extra_with_smartypants':
				$file = EXTENSIONS . '/markdown_guide/assets/markdown_extra_with_smartypants.php';
			break;
			case 'markdown_with_purifier':
				$file = EXTENSIONS . '/markdown_guide/assets/markdown_with_purifier.php';
			break;			
		}
		
		include($file);
		
		foreach($description as $line) {
			$contents .= "<strong>{$line[0]}:</strong> {$line[1]}<br />";
		}
		
		$guide = Widget::Label($contents, null, 'markdown_guide');
		$context['label']->appendChild($guide);
	}

	public function initaliseAdminPageHead($context) {
		$page = $context['parent']->Page;
		$page->addScriptToHead(URL . '/extensions/markdown_guide/assets/toggle_guide.js', 900200);
	}
}

?>
