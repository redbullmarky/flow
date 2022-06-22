# Flow
Experimenting with node-based programming

## Example

```php
<?php

use Flow\Runner;

$runner = new Runner();
$runner->load('mock.json');
$runner->run();
```

## Todo
Key known issues at this point, mainly:

- [ ] Emit proper events when an Input value is set to invoke execution of nodes
- [ ] Debugging features
- [ ] Type checking
- [ ] Finalise a proper set of nodes
- [ ] Decouple the nodetype specified in the file from the actual class; registration

Otherwise, plenty more in the pipeline.
