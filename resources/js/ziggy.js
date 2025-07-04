const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"contacts.create":{"uri":"contacts\/create","methods":["GET","HEAD"]},"contacts.index":{"uri":"contacts","methods":["GET","HEAD"]},"contacts.store":{"uri":"contacts","methods":["POST"]},"contacts.edit":{"uri":"contacts\/{contact}\/edit","methods":["GET","HEAD"],"parameters":["contact"],"bindings":{"contact":"id"}},"contacts.update":{"uri":"contacts\/{contact}","methods":["PUT","PATCH"],"parameters":["contact"]},"contacts.destroy":{"uri":"contacts\/{contact}","methods":["DELETE"],"parameters":["contact"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
