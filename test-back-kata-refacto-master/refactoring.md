# Explanation of refactoring Kata Test

###Commit "add private method hasText"

The method hasText allows to put the condition "strpos(argument1, argument2) !== false" in a function that is repeated very often.

###Commit "add private method replaceText"

The method replaceText allows to put the function "str_replace(argument1, argument2, argument3") in a function that is repeated very often.

###Commit "add phpDoc, modify variables and function clone"

Put the phpDoc for every function allows to indicate function's parameters and what type of response (string, instance, object, array etc) it should return.
I modified variables in order to use camelCase.  
I remove parenthesis of the function "clone". I used the function php "clone" that doesn't need parenthesis.  

###Commit "add getters/setters, modify the call to getters, remove variable useless"

+ I add getters/setters of the entities in order to can use the getters into TemplateManager.
The getter allows to recover the value associated with the getter.  
+ I renamed variables in order to be more understandable.  
+ I remove the variable "$quoteFromRepository" because the variable "$quote" is the same thing. It's an instance of Quote.  
+ I remove the condition ($this->hasText($text, '[quote:destination_link]')) that initialize the variable "$destination". This variable is already defined above.  
+ "Quote::renderHtml" calls the method "renderHtml" of the instance Quote. The variable $quote is too an instance of Quote. So, we can write "$quote->renderHtml". It's the same thing for the method "renderText".  
+  ucfirst and mb_strtolower allows to transform the variable's format. The getter (getFirstname()) takes care of the format.  

###Commit "add accolade into if/else"

Prefer the braces in order to clearly delineate the block and to have the same structure in the whole class
