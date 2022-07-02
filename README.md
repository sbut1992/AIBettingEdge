# AI Betting Edge Development

## Requirements

1. VSCode
2. Docker
3. Git

## Setup

1. Ensure the requirements are installed (recommend via brew)
2. From dev folder run `git clone <https://your-project-location.git>`
3. `cd` into project folder and run `vscode .`
4. VSCode should open with the project
5. From VSCode, select `Terminal > New Terminal`
6. Run `docker compose up` or `make start` (requires xcode)
7. Edit from the `/AIBettingEdgePlugin` folder
8. Refresh the page to see changes
9. From terminal, type `Control + C` to shut down the docker instance

## How the development environment is setup

The development environment uses a virtual infrastructure provided by Docker via the `docker-compose.yml` file.

The file uses virtual containers for Wordpress, the Wordpress CLI, PHPMyAdmin, MySQL, and mounts plugins from the source directory, all providing a complete wordpress solution for plugin development.
