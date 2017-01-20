source 'https://rubygems.org'

group :jekyll_plugins do
  # Enforce recent github pages version to work around
  # https://github.com/github/pages-gem/issues/351 and
  # https://github.com/bundler/bundler/issues/5154.
  #
  # The fix will be part of bundler 1.14
  gem 'github-pages', '>=112'

  # Live reload during development, see
  # https://github.com/jekyll/jekyll/pull/5142 for probable merge into jekyll
  # upstream
  gem 'jekyll-livereload'

  # Explicitly fetch json from Github, to work around build error in Ruby 2.4,
  # see https://github.com/flori/json/issues/308
  gem 'json', git: 'https://github.com/flori/json.git', branch: 'v1.8'
end