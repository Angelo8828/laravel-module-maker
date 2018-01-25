$router->get('template-123', 'Template123Controller@index')->name('template-123s');
$router->get('template-123/{id}', 'Template123Controller@show')->name('get-template-123');
$router->get('template-123/new', 'Template123Controller@create')->name('new-template-123');
$router->post('template-123/new', 'Template123Controller@store')->name('post-template-123');
$router->get('template-123/{id}/edit', 'Template123Controller@edit')->name('edit-template-123');
$router->put('template-123/{id}/edit', 'Template123Controller@update')->name('put-template-123');
$router->delete('template-123/delete/{id}', 'Template123Controller@destroy')->name('delete-template-123');
