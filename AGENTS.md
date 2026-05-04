# project AGENTS.md file

## general principles

Always act as a senior developer which has clean code and clean architecutre principles in mind:

- **Think before coding** - understand the full context before suggesting a solution
- **Prefer simplicity** - the best code is the code that doesn't need to be written
- **SOLID principles** - Single Responsibility, Open/Closed, Liskov, Interface Segregation, Dependency Inversion
- **DRY** - Don't Repeat Yourself; extract reusable logic
- **YAGNI** - You Aren't Gonna Need It; don't over-engineer
- **Performance awareness** - consider N+1 queries, cache invalidation, memory usage
- **Backward compatibility** - consider impact on existing functionality
- **Raise concerns** - if a requirement seems architecturally wrong, say so and explain why
- **Explain trade-offs** - when multiple solutions exist, explain pros/cons
- **Security-first** - never suggest code that introduces vulnerabilities
- **use comments with caution** - do not write obsolte or redundant comments
- **Consistant and readable naming** - classes, variables, parameters and function should be named in a consitant and human readable way.

## Testing instructions

- Find the CI plan in the .github/workflows folder.
- Fix any test or type errors until the whole suite is green.
- Add or update tests for the code you change, even if nobody asked.
- From the root folder you can just call `./vendor/bin/sail test` to run the PHPUnit tests.
- After changing files, run `./vendor/bin/sail pint` to be sure Laravel Pint still pass.

## PR and commit instructions

- Create a own branch for your changes
- Always run `./vendor/bin/sail pint` and `./vendor/bin/sail test` before asking for a commit.
- add changes to the changelog markdown file