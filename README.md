# TimeLimit
Pocket Mine Plugin for setting times to beat challenges. 

Defaul use:

	timelimit <ch|start|stop|complete|list>
	timelimit start [player] [challenge name]
	timelimit stop [player] [challenge name]
	timelimit complete [player] [challenge name] [time in MM:SS]
	
	timelimit ch <add|del|list> //Making the Challenges: NO SPACES IN [CHALLENGE NAMES]
	timelimit ch add [challenge name] [time in MM:SS] [commands]
	timelimit ch del [challenge name]
	timelimit ch list <all/pagenumber>

Limitations:
	NO SPACES IN [CHALLENGE NAMES]


TODO:
Challenge functions
- [x] add
- [x] del
- [x] list

	
Standard functions
- [ ] start
	- [x] add to db
	- [ ] Edit so only existing challenges can be run.
	- [ ]
- [ ] stop
- [ ] complete

