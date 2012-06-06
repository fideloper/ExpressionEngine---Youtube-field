# Youtube Fieldtype

A fieldtype for parsing Youtube links, grabbing the Youtube video ID and then allowing a user different ways to embed those videos within their site.

##Installation

###Simple Installation

Simply copy the pi.surgeree.php file into a directory called surgeree inside the third_party folder of your ExpressionEngine installation.

###Fancy Installation (for git users)

Make this repo into a submodule for your project's private ExpressionEngine git repo.

	git submodule add git://github.com/dsurgeons/SurgerEE.git system/expressionengine/third_party/surgeree

For added flexiblity, fork this repo and make the submodule to your fork instead. Don't forget to submit pull requests after you've added stuff :).

##Usage

Display video ID:

	{custom_field_name display='id'}

	<iframe title="YouTube video player" width="xxx" height="xxx" src="http://www.youtube.com/embed/{custom_field_name display='id'}" frameborder="0" allowfullscreen></iframe>

Display video URL: http://www.youtube.com/watch?v=VIDEOID

	{custom_field_name} (Default behavior)
	{custom_field_name display='url'}

Display youtube embed code:

	{custom_field_name display='embed' width='xxx' height='xxx'}

This will default to default width and height set in field settings.

Pass url parameters:

	{custom_field_name display='embed' url_params="wmode=transparent"}

##Changelog

###1.2
- Added ability to pass url parameters for generated embed code.
- Made url output consistent.

###1.1
- Updated for youtu.be/VIDEOID urls.
- Changed parameters to universal "display".

###1.0
- Created Youtube custom field to accept most popular youtube URLs and parse the youtube ID for later display.
