# Explanation of refactoring Kata Test

###Commit "add private method hasText"

The method hasText allows to put the condition "strpos(argument1, argument2) !== false" in a function that is repeated very often.

###Commit "add private method replaceText"

The method replaceText allows to put the function "str_replace(argument1, argument2, argument3") in a function that is repeated very often.

###Commit "add phpDoc, modify variables and function clone"

Put the phpDoc for every function allows to indicate function's parameters and what type of response (string, instance, object, array etc) it should return.
I modified variables in order to use camelCase.  
I remove parenthesis of the function "clone". I used the function php "clone" that doesn't need parenthesis.  
