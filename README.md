# Medas

Medas stands for `MorPHP Explicitly Defined Annotation System`. I've created this framework with the following main
goals in mind:

- To practice applying certain patterns, styles and practices
- To organize my own code

## Usability

I would not recommend using these packages yourself at this moment. Most of them only implement the features I've needed
so far, and nothing else.

## Patterns and styles

### Classes

Classes should aim to be either:

- Singleton services that do one thing, and one thing only
  - They should be readonly if possible
- Dumb data objects that do nothing by themselves

Other reasonable class types are:

- Singleton data objects that do nothing by themselves

### Dependencies

The packages should be independent of each other, mostly by using interface parameters.

### No magic

The amount of "magic" should be as low as possible:

- Require names and labels to be given by the user, instead of deriving them from context and class names
- Use configurable options with reasonable defaults that can be listed easily, instead of using values that can only be found by browsing the code or
  reading the documentation
- Use typed options instead of compound strings or arrays

### In general

- Use regular expressions only when it's necessary or vastly more optimal than parsing or deconstructing the string in
  question
