# Running console commands

The CLI entrypoint is `bin/console`. It bootstraps the application and passes the command-line arguments to the `CommandProcessor`.

## Listing available commands

Run without arguments to see all available commands:

```bash
php bin/medas medas:command-list
```

Pass a search term to filter the list:

```bash
php bin/medas medas:command-list cache
```

Each row shows the full command path, any aliases, and a description.

## Running a command

```bash
php bin/medas group:command-name
```

For example:

```bash
php bin/medas cache:clear-all
php bin/medas entity-manager:run-migrations
```

## Arguments and options

Positional arguments are passed after the command name:

```bash
php bin/medas group:command-name argument1 argument2
```

Options are passed with `--`:

```bash
php bin/medas group:command-name --format=json
php bin/medas group:command-name --verbose
```

Short option codes (where declared) can be used with `-`:

```bash
php bin/medas group:command-name -f json
```

## Aliases

Some commands declare short alias words that bypass the group path entirely:

```bash
php bin/medas c.entity   # alias for a longer command
```

Aliases are shown in the command list next to their full command path.

## Error handling

If a command throws an uncaught exception, the message is printed to the terminal and the process exits. The full stack trace is available through the configured exception logger.
