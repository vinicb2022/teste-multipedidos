import { Component, OnDestroy, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { WebSocketService } from '../services/websocket.service';

interface AnalysisEvent {
  analysisId: number;
  status: string;
  resultData?: {
    url: string;
    [key: string]: any;
  };
}

@Component({
  selector: 'app-analysis',
  template: `
    <div>
      <h2>Análise de Dados</h2>
      <button (click)="startAnalysis()" [disabled]="isProcessing">
        {{ isProcessing ? 'Processando...' : 'Iniciar Análise' }}
      </button>

      <div *ngIf="status">
        <p>Status da Análise #{{ analysisId }}: <strong>{{ status }}</strong></p>
        <a *ngIf="resultUrl" [href]="resultUrl" target="_blank">Ver Resultados</a>
      </div>
    </div>
  `,
})
export class AnalysisComponent implements OnInit, OnDestroy {
  isProcessing = false;
  status = '';
  analysisId: number | null = null;
  resultUrl: string | null = null;
  userId = 1;

  constructor(
    private http: HttpClient,
    private websocketService: WebSocketService
  ) {}

  ngOnInit() {
    this.listenForUpdates();
  }

  startAnalysis() {
    this.isProcessing = true;
    this.status = 'Iniciando...';

    this.http.post<{ analysisId: number }>('/api/analysis/start', {}).subscribe(response => {
      this.analysisId = response.analysisId;
      this.status = 'Processando...';
    });
  }

  listenForUpdates() {
    this.websocketService.echo
      .private(`user.${this.userId}`)
      .listen('.analysis.status.updated', (event: AnalysisEvent) => {
        if (event.analysisId === this.analysisId) {
          this.status = event.status;
          this.isProcessing = false;

          if (event.status === 'Concluído' && event.resultData) {
            this.resultUrl = event.resultData.url;
          }
        }
      });
  }

  ngOnDestroy() {
    this.websocketService.echo.leave(`user.${this.userId}`);
  }
}