#!/bin/bash
# Show Gource animation :)
gource --title "Symfony2" -s .25 --file-idle-time 600  --auto-skip-seconds 1 -1920x1080 --output-framerate 30 --stop-at-end --max-files 1000000 --bloom-multiplier 1.1 --bloom-intensity .25 --background 101010  --highlight-dirs --highlight-users --hide filenames,date,progress
