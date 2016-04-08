package org.netbeans.rest.application.config;

import java.util.HashSet;
import java.util.Set;
import javax.ws.rs.ApplicationPath;
import javax.ws.rs.core.Application;
import vn.khmt.hello.restful.CORSFilter;
import vn.khmt.hello.restful.HelloService;

@ApplicationPath("")
public class ApplicationConfig extends Application {
    @Override
    public Set<Class<?>> getClasses() {
        Set<Class<?>> resources = new HashSet<>();
        resources.add(HelloService.class);
        resources.add(CORSFilter.class);
        return resources;
    }
}
