$router->get('template-123s', 'Template123Controller@index')->name('template-123s');
$router->get('template-123s/{id}', 'Template123Controller@show')->name('get-template-123');
$router->get('template-123s/new', 'Template123Controller@create')->name('new-template-123');
$router->post('template-123s/new', 'Template123Controller@store')->name('post-template-123');
$router->get('template-123s/{id}/edit', 'Template123Controller@edit')->name('edit-template-123');
$router->put('template-123s/{id}/edit', 'Template123Controller@update')->name('put-template-123');
$router->delete('template-123s/delete/{id}', 'Template123Controller@destroy')->name('delete-template-123');
