#TODO:
Challenge functions 
- [ ] add 
	- [x] add new challenge with commands
	- [ ] update challenge with additional command
	
- [x] del
	- [x] deletes command and challenges
- [x] list
	- [x] lists challenges in page format (5 per)
	- [x] put "all" to list all challenges in console.
- [x] top (show the desc list of fastest wins per challenge)

	
Standard functions
- [x] start
	- [x] add to db
	- [x] Edit so only existing challenges can be run.
	- [x] if failed challenge respawn
	- [ ] respawn to challenge start point.
- [x] stop
 	- [ ] removes start, stop and active from DB
- [x] complete 
	- [x] removes "active" challenge from DB
	- [x] runs commands in config file. associated

Other Stuff
- Misc:
	- [ ] Add - "Please run this command in game." to commands
		- set for these commands
		- [ ] starttimelimit
		- [ ] completetimelimit
		- [ ] 
- Death Event
	- [ ] notify player they failed
	- [ ] stop active challenge
	 
- Set permissions for plugin
	- [ ] Guest access
		- Challenges
			- [ ] listchallenge
		-Timelimit
			- [ ] starttimelimit
			- [ ] completetimelimit (limit from being typed in console somehow - so people can't cheat)
	- [ ] OP access
		- Challenges
			- [ ] addchallenge
			- [ ] delchallenge
		- Timelimit
			- [ ] stoptimelimit
