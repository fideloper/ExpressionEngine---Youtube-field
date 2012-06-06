# Youtube Fieldtype

A fieldtype for parsing Youtube links, grabbing the Youtube video ID and then allowing a user different ways to embed those videos within their site.

##Usage as of version 1.1:

Display video ID:

	{custom_field_name display='id'}

Display video URL: http://www.youtube.com/watch?v=VIDEOID

	{custom_field_name} (Default behavior)
	{custom_field_name display='url'}

Display youtube embed code:

	<iframe title="YouTube video player" width="xxx" height="xxx" src="http://www.youtube.com/embed/VIDEOID" frameborder="0" allowfullscreen></iframe>

Will default to default width and height set in field settings.

	{custom_field_name display='embed' width='xxx' height='xxx'}

##Usage as of version 1.0:

Display video ID:

	{custom_field_name id_only="yes"}

Display video URL: http://www.youtube.com/watch?v=VIDEOID

	{custom_field_name}

Display youtube embed code:

	{custom_field_name embed='yes' width='xxx' height='xxx'}

##Changelog

###1.1
- Updated for youtu.be/VIDEOID urls.
- Changed parameters to universal "display".

###1.0
- Created Youtube custom field to accept most popular youtube URLs and parse the youtube ID for later display.
