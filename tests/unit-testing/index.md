---
permalink: /tests/unit-testing
layout: markdown
title: Unit Testing
boilerplate: https://github.com/pixelgrade/boilerplate
---
This is the guide for **tests**. We will tackle both behaviour and technical details.

## Why do we need unit testing?

"QA should find nothing!" is the motto you should live and program by. Programs that test other programs can help a lot in reducing errors.

## What is their purpose?

Unit Tests shouldn't be used as a way to find bugs or detect regressions. Their purpose would be to examine each individual unit (software components) of our code separately. It's true that those units will eventually be interdependent with each other when the whole application is ran, but that is not something we should intend to test using unit tests.
Unit testing will only provide the means that an individual unit runs as it was designed to run.

```
Note: An exception where unit tests do effectively detect bugs is when we're refactoring a unit's code without meaning to change its behaviour. In this specific case unit testing will tell you if that unit's behaviour has changed.
```

## When should we write tests?

- When designing a single component. 

As a general rule, unit testing shouldn't be used for testing the entire system - i.e. **detect regressions**. 

## How should we write tests ?

- Each test should be independent to all the others
- Each test should test only one unit at a time. Our architecture should support testing units (classes or very small groups of classes) separately, not all chained together.  Otherwise, behaviour in those external services overlaps multiple tests, and state data means that different unit tests can influence each other’s outcome. 
- Avoid having common setup code that runs at the beginning of lots of unrelated tests. Ideally - we could have a very small setup method that is called by each test. (but only if those tests require all the preconditions from the setup method).

## Setting up our testing environment

In our specific case, since we work with PHP we'll use PHP Unit to build a unit test suite.
You can find an example of how to setup your test environment [here](https://github.com/pixelgrade/automated-tests).

## Structure

- **Title**
  - Each test should have a *title* (usually referencing the name of the method we want to test and the **scenario** we want to apply in that test -> i.e. `test_post_contains_install_data_success()` ). Don't be afraid to be as descriptive as possible in naming your test method.
- **Scenario** 
  - We should create a *scenario* about what our future unit wants to achieve. E.g. testing that method x returns a correctly formatted JSON string with properties z, y. This way we will know the exact bevahiour of our method before we actually start writing it.
- **Result**
  - Each test should have a *result* -> rendering a specific page or returning a specific message. This result should usually determine if the test has passed or not.

Here is an example of a test that contains a **title** (visible in the method name), a **scenario** (visible both in the method name as well as in the method description) and a **result** (given by calling the `assertEquals` method that is specific to phpunit).

```php
<?php

class Test_Pixelgrade_DataCollector extends WP_UnitTestCase {

 /**
 * This method tests that the get_post_data() function returns an stdObject that contains the following properties: install_data, active_plugins, system_data, theme_options and core_options
 */
 function test_post_contains_install_data_success() {
		$mockDataCollector = $this->createMock(PixelgradeCare_DataCollector::class);

		// Get Data
		$dataCollector = new PixelgradeCare_DataCollector($this->pluginName, $this->pluginVersion);

		// Mock the DataCollector Class
		$data = new \stdClass();
		$data->install_data = json_encode(array('foo' => 'bar'));
        $data->active_plugins = json_encode(array('foo'));
        $data->system_data = json_encode(array('foo' => 'bar'));
        $data->theme_options = json_encode(array('foo' => 'bar'));
        $data->core_options = json_encode(array('foo' => 'bar'));

		$mockDataCollector->method('get_post_data')
			->willReturn($data);

		$this->assertEquals(property_exists($mockDataCollector->get_post_data(), 'install_data'), property_exists($dataCollector->get_post_data(), 'install_data'));
		$this->assertEquals(property_exists($mockDataCollector->get_post_data(), 'active_plugins'), property_exists($dataCollector->get_post_data(), 'active_plugins'));
		$this->assertEquals(property_exists($mockDataCollector->get_post_data(), 'system_data'), property_exists($dataCollector->get_post_data(), 'system_data'));
		$this->assertEquals(property_exists($mockDataCollector->get_post_data(), 'theme_options'), property_exists($dataCollector->get_post_data(), 'theme_options'));
		$this->assertEquals(property_exists($mockDataCollector->get_post_data(), 'core_options'), property_exists($dataCollector->get_post_data(), 'core_options'));
	}
}
?>
```