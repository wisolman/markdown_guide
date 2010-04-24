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
			'version' => '1.0'
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
		);
	}
	
	public function addGuideBelowTextArea($pointer) {
		//only show guide when using markdown
		$formatter = substr($pointer['field']->get('formatter'), 0,  11);
		if ($formatter != 'pb_markdown') return;

		//append the textarea here so the guide will show after the textarea in the form
		$pointer['label']->appendChild($pointer['textarea']);

		//nullify the textarea to prevent another one being appended in field.textarea.php
		$pointer['textarea'] = Widget::Label('');

		//retrieve the guide and append it
		$file = DOCROOT . '/extensions/markdown_guide/guide.txt';
		$contents = file_get_contents($file);
		$guide = Widget::Label($contents);
		$pointer['label']->appendChild($guide);
	}
}

?>
