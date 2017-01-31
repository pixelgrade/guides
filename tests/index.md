---
permalink: /tests/
layout: markdown
title: Testing our code
boilerplate: https://github.com/pixelgrade/boilerplate
---

### Why write test at all ?

- TDD tells you when you've finished writing the code for each individual unit of your application.
- Unit Tests help you define the architecture of your application. Instead of writing code to do something - you first visualize what you need to do and then start writing the code for it. This should dramatically decrease the time it takes you to write the actual code.
- Unit Tests allow you to make changes to your code quickly. You know your component works correctly when the tests pass.

Depending on what our ultimate goal for testing our code is, we might need to apply one of the following techniques:

| Goal | Technique |
| ---  | --- |
| **Designing software components** for your application (`units`) | **T**est **D**riven **D**evelopment (with **unit-testing**) |
| Finding **bugs** (usually after our application's code has been written) | **Manual Testing** |
| Verifying *functionality, performance, reliability* as well as *detecting regressions* | **Integration Testing** |