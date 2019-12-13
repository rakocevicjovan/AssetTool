Game resource serializer

This tool allows the user to define game resources fit for the engine in the procedural generation and graphics 
repository at https://github.com/rakocevicjovan/PCG_and_graphics.

Definitions for game resources, such as 3d meshes, textures, animations, skeletons, shaders etc. can be stored in the 
database. Game project definitions and level definitions can be stored as well.

This tool allows you to define your assets like this, and link them with game levels, which are further linked to game projects.
At a latter time, links between these resources can be used to export entire game level's worth of resources in a file.

In order to load a game level, the user simply exports a level as a JSON file, which collects all resource definitions 
associated to that level and then writes them to a file fit for consumption of the resource loading system in your game engine.

Some convenient data can be added to the resources  as well, which is not necessarily used during runtime in the game.
This allows for the user to reason about resources and leave notes for other users. 

There is no intention to provide versioning support or backups/redundancy. This is not industry grade software just a 
little helper program for my little engine.

It is still not feature rich, however it is robust, easy to use, portable (web tool, cmon!) and quite easy to extend in Symfony.
It's used only for a personal project so it's resource descriptions are not data driven, therefore you must know 
your way around Symfony in order to tailor it to your own engine's needs...
If you happen to somehow be knowledgeable about Symfony and are doing game programming... long shot I know... 
this tool can be useful to you - feel free to use it, or base your own off of it!