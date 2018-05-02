#!/bin/bash

#Push files to VersionControl server

$funcVar = $1 #sets function variable to first argument after script name
$verNum = $2 #set verNum to second argument

	if [$funcVar == "push"] then
		#Tars VerCon as variable name
        	tar -czvf $verNum /home/tariq/VerCon

               #sets tar file to variable
               tarVar="$verNum.tar.gz"

               #sets path variable
               pathVar="/home/tariq/$tarVar"

               #transfers tar file from Tariq's Prod to Roddy's VC
               scp tariq@192.168.1.106:$pathVar rod@192.168.1.109:/home/rod/IT490/VersionControl/
	 	

		echo "Version sent"

	elif [$funcVar == "pull"] then
		#Tars VerCon as variable name
		tar -czvf $verNum /home/roddy/VCS

		#sets tar file to variable
		tarVar="$verNum.tar.gz"

		#sets path variable
		pathVar="/home/roddy/VCS/$tarVar"

		#transfers tar file from Roddy's VC to ///
		scp roddy@192.168.1.109:/home/rod/IT490/VersionControl/ tariq@192.168.1.106:$pathVar

		echo "Version received"

       else 
                echo $funcVar + "is an invalid command. Please specify 'push' or 'pull'.";
        fi
~                                                                                                        
~               
