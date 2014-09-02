clean:
	rm -rf *~ *#
fullclean:

	sudo rm -rf *~ *# file/* .git

	sudo rm -rf *~ *# file/*
commit:
	git init
	git add *
	git commit -m 'partage-mdp'
	git remote add origin https://github.com/ymah/partage-securise.git
	git push -u origin master 

recommit:
	git pull origin master
	git add *
	git commit -m 'test'
	git push -u origin master


