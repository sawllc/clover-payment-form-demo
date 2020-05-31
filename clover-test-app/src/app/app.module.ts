import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { CloverCheckoutComponent } from './clover-checkout/clover-checkout.component';
import { ScriptService } from './clover-checkout/shared/script.service';

@NgModule({
  declarations: [
    AppComponent,
    CloverCheckoutComponent
  ],
  imports: [
    BrowserModule
  ],
  providers: [
  	ScriptService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }